<?php

class Rib
{
	/**
	 * Rib validator
	 * 
	 * @author petitchevalroux
	 * @licence originale http://creativecommons.org/licenses/by-sa/2.0/fr/
	 * @see http://dev.petitchevalroux.net/php/valider-rib-php.359.html
	 * @see also http://fr.wikipedia.org/wiki/Relev%C3%A9_d%27identit%C3%A9_bancaire
	 * @param string $rib
	 * @return boolean
	 */
	public static function validate($rib)
	{
		if(mb_strlen($rib) !== 23)
		{
			return false;
		}
		$key = substr($rib,-2);
		$bank = substr($rib,0,5);
		$bank = substr($rib,0,5);
		$branch = substr($rib,5,5);
		$account = substr($rib,10,11);
		$account = strtr($account,
		'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
		'12345678912345678923456789');
		return 97 - bcmod(89*$bank + 15 * $branch + 3 * $account,97) === (int)$key;
	}
}
?>
