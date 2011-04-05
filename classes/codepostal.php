<?php

class CodePostal
{
	/**
	 * CODE POSTAL fre-fr validator
     * Attention, nombreuses particularités, cf. Wikipedia.
	 * 
	 * @author ronan.guilloux
	 * @param string $codepostal
     * @see http://fr.wikipedia.org/wiki/Code_postal_en_France
	 * @return boolean
	 */
	public static function validate( $codepostal )
	{
        $regexp = "/^[0-9]{5}$/";
        return (boolean)preg_match( $regexp, $codepostal );
	}
}
?>
