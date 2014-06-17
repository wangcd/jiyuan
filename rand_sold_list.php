<?php
if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}
$list_num = 99; //要能被3除尽
$name_str = "陈,李,张,刘,王,杨,黄,孙,周,吴,徐,赵,朱,马,胡,郭,林,何,高,梁,郑,罗,宋,谢,唐,韩,曹,许,邓,萧,冯,曾,程,蔡,彭,潘,袁,于,董,余,苏,叶,吕,魏,蒋,田,杜,丁,沈,姜,范,江,傅,钟,卢,汪,戴,崔,任,陆,廖,姚,方,金,邱,夏,谭,韦,贾,邹,石,熊,孟,秦,阎,薛,侯,雷,白,龙,段,郝,孔,邵,史,毛,常,万,顾,赖,武,康,贺,严,尹,钱,施,牛,洪,龚,汤,陶,黎,温,莫,易,樊,乔,文,安";
$name_arr = array_reverse(explode(',', $name_str));
//var_dump($name_arr);
$name_num = count($name_arr);
for ($i = 0; $i < $name_num; $i++) {
	for ($j = 0; $j < $i; $j++) {
		$name_arr[] = $name_arr[$i];
	}
}
shuffle($name_arr);

$name_rand_keys = array_rand($name_arr,$list_num);

$sql = 'SELECT g.goods_id, g.shop_price, g.goods_name, g.goods_name_style ' .
	' FROM ' . $GLOBALS['ecs']->table('goods') . ' AS g ' .
	' WHERE g.is_on_sale = 1 AND g.is_alone_sale = 1 AND g.is_delete = 0 AND (g.is_best = 1 OR g.is_new =1 OR g.is_hot = 1)';
$goods_res = $db->getAll($sql);

$sql2 = 'SELECT g.goods_id, g.shop_price, g.goods_name, g.goods_name_style ' .
	' FROM ' . $GLOBALS['ecs']->table('goods') . ' AS g ' .
	' WHERE g.is_on_sale = 1 AND g.is_alone_sale = 1 AND g.is_delete = 0 AND g.is_best = 0 AND g.is_new =0 AND g.is_hot = 0';
$goods_res2 = $db->getAll($sql2);

$goods_res = array_merge($goods_res , $goods_res , $goods_res , $goods_res2);

shuffle($goods_res);
$goods_rand_keys = array_rand($goods_res,$list_num);

$color_arr = array('#f8e2ac','#f5f5f5','#ffe6ec');
$rand_sold_list = array();
for ($i = 0; $i < $list_num; $i++) {
	$rand_sold_list[$i] = $goods_res[$goods_rand_keys[$i]];
	$rand_sold_list[$i]['short_name']   = $_CFG['goods_name_length'] > 0 ?
                                               sub_str($goods_res[$goods_rand_keys[$i]]['goods_name'], $_CFG['goods_name_length']) : $goods_res[$goods_rand_keys[$i]]['goods_name'];
    $rand_sold_list[$i]['short_style_name']   = add_style($rand_sold_list[$i]['short_name'],$goods_res[$goods_rand_keys[$i]]['goods_name_style']);
	$rand_sold_list[$i]['url'] = build_uri('goods', array('gid' => $goods_res[$goods_rand_keys[$i]]['goods_id']), $goods_res[$goods_rand_keys[$i]]['goods_name']);
	$rand_sold_list[$i]['buyer'] = $name_arr[$name_rand_keys[$i]] . '先生';
	$rand_sold_list[$i]['color'] = $color_arr[($i % 3)];
}
$smarty->assign('rand_sold_list', $rand_sold_list);
