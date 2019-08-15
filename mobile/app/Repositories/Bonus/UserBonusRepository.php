<?php
//zend websc在线更新版         
namespace App\Repositories\Bonus;

class UserBonusRepository
{
	public function getUserBonusCount($userId)
	{
		return \App\Models\UserBonus::where('user_id', $userId)->count();
	}
}


?>
