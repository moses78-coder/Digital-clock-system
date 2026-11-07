<?php
require_once __DIR__.'/../config/database.php';
require_once __DIR__.'/../includes/csrf.php';
header('Content-Type: application/json; charset=utf-8');
function out($data,$code=200){http_response_code($code);echo json_encode($data);exit;}
if($_SERVER['REQUEST_METHOD']==='GET'){
 $res=$conn->query("SELECT id,label,alarm_at,repeat_daily,is_enabled,last_triggered_date FROM alarms ORDER BY alarm_at");
 $items=[];while($r=$res->fetch_assoc()){$r['repeat_daily']=(bool)$r['repeat_daily'];$r['is_enabled']=(bool)$r['is_enabled'];$items[]=$r;}
 out(['success'=>true,'alarms'=>$items]);
}
if($_SERVER['REQUEST_METHOD']!=='POST')out(['success'=>false,'message'=>'Method not allowed'],405);
$headers=function_exists('getallheaders')?getallheaders():[];$token=$headers['X-CSRF-Token']??$headers['x-csrf-token']??'';
if(!$token||!hash_equals($_SESSION['csrf_token']??'',$token))out(['success'=>false,'message'=>'Invalid security token. Refresh the page.'],419);
$data=json_decode(file_get_contents('php://input'),true)??[];$action=$data['action']??'';
if($action==='create'){
 $label=trim($data['label']??'');$raw=trim($data['alarm_at']??'');$repeat=!empty($data['repeat_daily'])?1:0;
 $dt=DateTime::createFromFormat('Y-m-d\TH:i',$raw);
 if(!$label||strlen($label)>80||!$dt||$dt->format('Y-m-d\TH:i')!==$raw)out(['success'=>false,'message'=>'Enter a valid alarm description and date/time.'],422);
 if(!$repeat&&$dt<=new DateTime())out(['success'=>false,'message'=>'Choose a future alarm time.'],422);
 $when=$dt->format('Y-m-d H:i:s');$s=$conn->prepare("INSERT INTO alarms(label,alarm_at,repeat_daily) VALUES(?,?,?)");$s->bind_param('ssi',$label,$when,$repeat);$s->execute();
 out(['success'=>true,'message'=>'Alarm saved.'],201);
}
$id=filter_var($data['id']??null,FILTER_VALIDATE_INT);if(!$id)out(['success'=>false,'message'=>'Invalid alarm ID.'],422);
if($action==='toggle'){$s=$conn->prepare("UPDATE alarms SET is_enabled=1-is_enabled WHERE id=?");$s->bind_param('i',$id);$s->execute();out(['success'=>true]);}
if($action==='delete'){$s=$conn->prepare("DELETE FROM alarms WHERE id=?");$s->bind_param('i',$id);$s->execute();out(['success'=>true]);}
if($action==='fired'){$today=date('Y-m-d');$s=$conn->prepare("UPDATE alarms SET last_triggered_date=? WHERE id=?");$s->bind_param('si',$today,$id);$s->execute();out(['success'=>true]);}
out(['success'=>false,'message'=>'Unknown action.'],400);
