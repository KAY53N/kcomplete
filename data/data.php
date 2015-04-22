<?php
/**
 *  author:		xujiantao - http://www.xujiantao.com
 *	2012-09-22
 */
header("Content-type:text/html; charset=utf-8");
$arr = array(
		"Ädams, Egbert",
		"Altman, Alisha",
		"Archibald, Janna",
		"Auman, Cody",
		"Bagley, Sheree",
		"Ballou, Wilmot",
		"Bard, Cassian",
		"Bash, Latanya",
		"Beail, May",
		"Black, Lux",
		"Bloise, India",
		"Blyant, Nora",
		"Bollinger, Carter",
		"Burns, Jaycob",
		"Carden, Preston",
		"Carter, Merrilyn",
		"Christner, Addie",
		"Churchill, Mirabelle",
		"Conkle, Erin",
		"Countryman, Abner",
		"Courtney, Edgar",
		"Cowher, Antony",
		"Craig, Charlie",
		"Cram, Zacharias",
		"Cressman, Ted",
		"Crissman, Annie",
		"Davis, Palmer",
		"Downing, Casimir",
		"Earl, Missie",
		"Eckert, Janele",
		"Eisenman, Briar",
		"Fitzgerald, Love",
		"Fleming, Sidney",
		"Fuchs, Bridger",
		"Fulton, Rosalynne",
		"Fye, Webster",
		"Geyer, Rylan",
		"Greene, Charis",
		"Greif, Jem",
		"Guest, Sarahjeanne",
		"Harper, Phyllida",
		"Hildyard, Erskine",
		"Hoenshell, Eulalia",
		"Isaman, Lalo",
		"James, Diamond",
		"Jenkins, Merrill",
		"Jube, Bennett",
		"Kava, Marianne",
		"Kern, Linda",
		"Klockman, Jenifer",
		"Lacon, Quincy",
		"Laurenzi, Leland",
		"Leichter, Jeane",
		"Leslie, Kerrie",
		"Lester, Noah",
		"Llora, Roxana",
		"Lombardi, Polly",
		"Lowstetter, Louisa",
		"Mays, Emery",
		"Mccullough, Bernadine",
		"Mckinnon, Kristie",
		"Meyers, Hector",
		"Monahan, Penelope",
		"Mull, Kaelea",
		"Newbiggin, Osmond",
		"Nickolson, Alfreda",
		"Pawle, Jacki",
		"Paynter, Nerissa",
		"Pinney, Wilkie",
		"Pratt, Ricky",
		"Putnam, Stephanie",
		"Ream, Terrence",
		"Rumbaugh, Noelle",
		"Ryals, Titania",
		"Saylor, Lenora",
		"Schofield, Denice",
		"Schuck, John",
		"Scott, Clover",
		"Smith, Estella",
		"Smothers, Matthew",
		"Stainforth, Maurene",
		"Stephenson, Phillipa",
		"Stewart, Hyram",
		"Stough, Gussie",
		"Strickland, Temple",
		"Sullivan, Gertie",
		"Swink, Stefanie",
		"Tavoularis, Terance",
		"Taylor, Kizzy",
		"Thigpen, Alwyn",
		"Treeby, Jim",
		"Trevithick, Jayme",
		"Waldron, Ashley",
		"Wheeler, Bysshe",
		"Whishaw, Dodie",
		"Whitehead, Jericho",
		"Wilks, Debby",
		"Wire, Tallulah",
		"Woodworth, Alexandria",
		"Zaun, Jillie",
		"徐建涛",
		"徐先生",
		"徐女士",
		"徐静蕾",
		"徐怀钰",
		"徐熙媛",
		"张三",
		"张栋梁",
		"张可可",
		"张杰",
		"张柏芝",
		"李四"
);

$input = strtolower($_GET["input"]);
$len = strlen($input);
$language = preg_match("/^[".chr(0x80)."-".chr(0xff)."]+$/",$input);
$result = array();
$count = 0;

if(isset($len) && ($language == 0))
{
	for($i=0;$i<count($arr);$i++)
    {
		if(strtolower(substr($arr[$i],0,$len)) == strtolower($input))
        {
			$count++;
			$result[] = array("id"=>$i,"value"=>$arr[$i]);
		}
	}
}

if(isset($len) && ($language == 1))
{
	function msubstr($str, $start=0, $length, $charset="utf-8")
    {
		if(function_exists("mb_substr"))
        {
			return mb_substr($str, $start, $length, $charset);
        }
        else if(function_exists('iconv_substr'))
        {
			return iconv_substr($str,$start,$length,$charset);
		}

		$re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
		$re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
		$re['gbk']	  = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
		$re['big5']	  = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
		preg_match_all($re[$charset], $str, $match);
		$slice = join("",array_slice($match[0], $start, $length));
		return $slice;
	}

	function abslength($str)
    {
    	if(empty($str))
        {
        	return 0;
    	}
    	if(function_exists('mb_strlen'))
        {
        	return mb_strlen($str,'utf-8');
    	}
        else
        {
        	preg_match_all("/./u", $str, $ar);
        	return count($ar[0]);
    	}
	}
	$cnlen = abslength($input);

	for($i=0;$i<count($arr);$i++)
    {
		if(msubstr($arr[$i],0,$cnlen) == $input)
        {
			$count++;
			$result[] = array("id"=>$i,"value"=>$arr[$i]);
		}
	}
}

if(empty($input))
{
	echo "";
}
else
{
	echo json_encode($result);
}
?>
