<?php
//zend websc在线更新版         
namespace App\Repositories\Comment;

class CommentRepository
{
	public function orderAppraiseAdd($args)
	{
		$commemt = new \App\Models\Comment();

		foreach ($args as $k => $v) {
			$commemt->$k = $v;
		}

		return $commemt->save();
	}
}


?>
