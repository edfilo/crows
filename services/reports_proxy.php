<?
/*
 * Crows - Crowd Syndication 1.0
 * Copyright 2009
 * contact@crowsne.st
 * http://www.crowsne.st/license
 */


include_once('../config.php');
header("Content-type: text/json");

//php<5.2 json_encode  compatibility function

if (!function_exists('json_encode'))
{
  function json_encode($a=false)
  {
    if (is_null($a)) return 'null';
    if ($a === false) return 'false';
    if ($a === true) return 'true';
    if (is_scalar($a))
    {
      if (is_float($a))
      {
        // Always use "." for floats.
        return floatval(str_replace(",", ".", strval($a)));
      }

      if (is_string($a))
      {
        static $jsonReplaces = array(array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
        return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $a) . '"';
      }
      else
        return $a;
    }
    $isList = true;
    for ($i = 0, reset($a); $i < count($a); $i++, next($a))
    {
      if (key($a) !== $i)
      {
        $isList = false;
        break;
      }
    }
    $result = array();
    if ($isList)
    {
      foreach ($a as $v) $result[] = json_encode($v);
      return '[' . join(',', $result) . ']';
    }
    else
    {
      foreach ($a as $k => $v) $result[] = json_encode($k).':'.json_encode($v);
      return '{' . join(',', $result) . '}';
    }
  }
}

	switch($database_type) {

		case "csv":
			$row = 1;
			
			$rowcount=count(file("../reports.csv"));
			
			$handle = fopen("../reports.csv", "r");
			
			$i=1;
				
			if($rowcount==0){
				$array[0]=array('id'=>1,'title'=>'No reports yet. Make the first!'); 
			}
			
			while(($data = fgetcsv($handle, 0, "|"))!== FALSE) {
				
				$reports['id']=$i;
				$reports['date']=$data[0].'';
				$reports['title']=$data[1].'';
				$reports['name']=$data[2].'';
				$reports['location']=$data[3].'';
				$reports['lat']=$data[4].'';
				$reports['long']=$data[5].'';
				$reports['report']=$data[6].'';
				$reports['link']=$data[7].'';
				$reports['photo']=$data[8].'';
				$reports['embed']=$data[9].'';
				$array[$i]=$reports;
				$i++;
			}
		 
			
			$array=array_reverse($array);
			break;
		case "sqlite":
			$dbhandle = new SQLite3('../db/database.sqlite3');
			$result = $dbhandle->query('SELECT id, date, title, name, location, lat, long, report, link, photo, embed FROM reports');
			while ($data = $result->fetchArray(SQLITE3_ASSOC)) {
				$reports['id']=$data['id'];
				$reports['date']=$data['date'].'';
				$reports['title']=$data['title'].'';
				$reports['name']=$data['name'].'';
				$reports['location']=$data['location'].'';
				$reports['lat']=$data['lat'].'';
				$reports['long']=$data['long'].'';
				$reports['report']=$data['report'].'';
				$reports['link']=$data['link'].'';
				$reports['photo']=$data['photo'].'';
				$reports['embed']=$data['embed'].'';
				$array[]=$reports;
			}
			$array = array_reverse($array);
			break;

	}
	
	print(json_encode($array));
	
?>
