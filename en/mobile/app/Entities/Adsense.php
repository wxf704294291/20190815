<?php
//zend websc在线更新版         
namespace App\Entities;

class Adsense extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'adsense';
	public $timestamps = false;
	protected $fillable = array('from_ad', 'referer', 'clicks');
	protected $guarded = array();

	public function getFromAd()
	{
		return $this->from_ad;
	}

	public function getReferer()
	{
		return $this->referer;
	}

	public function getClicks()
	{
		return $this->clicks;
	}

	public function setFromAd($value)
	{
		$this->from_ad = $value;
		return $this;
	}

	public function setReferer($value)
	{
		$this->referer = $value;
		return $this;
	}

	public function setClicks($value)
	{
		$this->clicks = $value;
		return $this;
	}
}

?>
