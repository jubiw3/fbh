<?php
$films=array();
if(isset($_GET['city']))
{
	$response = file_get_contents('http://api.filmaster.pl/1.1/town/pl/?limit=1000');
	
	if($arr = json_decode($response))
	{
		foreach($arr->objects as $k=>$v)
		{
			if($v->name == $_GET['city'])
			{
				$response2 = file_get_contents('http://api.filmaster.pl'.$v->showtimes_uri.date('Y-m-d').'/?include=film,channels');
				
				if($arr2 = json_decode($response2))
				{
					$x=0;
					foreach($arr2->objects as $v2)
					{
						
						//print_r($v2->film->title_localized);
						$films[$x]['title']=$v2->film->title_localized;
						$films[$x]['permalink']=$v2->film->permalink;
						$x++;
					}
				}

				//http://api.filmaster.pl/1.1/town/pl/
				//print_r($response2);
			}
		}
	}

}


if(!$films)
{
	$films[]='No films available';
}

echo ''.json_encode($films).'';

?>