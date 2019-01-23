<?php
namespace Home\TagLib;

use Think\Template\TagLib;

/**
 * 标签库
 */
class Lingyun extends TagLib
{
	/**
	 * 定义标签列表
	 */
	protected $tags
		= [
			'sql_query' => ['attr' => 'sql,result', 'close' => 0],             //SQL查询
		];

	/**
	 * SQL查询
	 */
	public function _sql_query($tag, $content)
	{
		$sql    = $tag['sql'];
		$result = !empty($tag['result']) ? $tag['result'] : 'result';
		$parse  = '<?php $'.$result.' = M()->query("'.$sql.'");';
		$parse  .= 'if($'.$result.'):?>'.$content;
		$parse  .= "<?php endif;?>";
		return $parse;
	}
}
