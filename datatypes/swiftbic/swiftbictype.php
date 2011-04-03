<?php

/*
 SWIFT - BIC datatype for eZ Publish 4.1.3 minimum
 /*!

 \class   Swiftbictype Swiftbictype.php
 \date    31 mars 2011
 \author  Ronan GUILLOUX
 */

include_once( 'kernel/common/i18n.php' );
include_once( 'extension/rgisocodes/classes/swiftbic.php' );

class SwiftbicType extends eZDataType
{
	const DATATYPE_STRING = 'swiftbic';

	/* Constructor */
	function SwiftbicType()
	{
		$this->eZDataType( 	self::DATATYPE_STRING, ezi18n( 'kernel/classes/datatypes', "SWIFT - BIC code", 'Datatype name' ),
							array( 	'serialize_supported' => true ) );
	}

	/*
	 Private method, only for using inside this class.
	 */
	function validateSwiftbicHTTPInput( $swiftbic, $contentObjectAttribute )
	{
		if ( !SwiftBic::validate( $swiftbic ) )
		{
			$contentObjectAttribute->setValidationError( ezi18n( 'kernel/classes/datatypes', 'The SWIFT - BIC code is not valid.' ) );
			return eZInputValidator::STATE_INVALID;
		}
		return eZInputValidator::STATE_ACCEPTED;
	}

	/*!
	 Sets the default value.
	 */
	function initializeObjectAttribute( $contentObjectAttribute, $currentVersion, $originalContentObjectAttribute )
	{
		if ( $currentVersion != false )
		{
			$dataText = $originalContentObjectAttribute->attribute( "data_text" );
			$contentObjectAttribute->setAttribute( "data_text", $dataText );
		}
	}

	/*!
	 Validates the input and returns true if the input was
	 valid for this datatype.
	 */
	function validateObjectAttributeHTTPInput( $http, $base, $contentObjectAttribute )
	{
		if ( $http->hasPostVariable( $base . '_data_text_' . $contentObjectAttribute->attribute( 'id' ) ) )
		{
			$swiftbic = $http->postVariable( $base . '_data_text_' . $contentObjectAttribute->attribute( 'id' ) );
			$classAttribute = $contentObjectAttribute->contentClassAttribute();

			$swiftbic = trim( $swiftbic );

			if ( $swiftbic == "" )
			{
				// we require user to enter an address only if the attribute is not an informationcollector
				if ( !$classAttribute->attribute( 'is_information_collector' ) and
				$contentObjectAttribute->validateIsRequired() )
				{
					$contentObjectAttribute->setValidationError( ezi18n( 'kernel/classes/datatypes', 'The SWIFT - BIC code is empty.' ) );
					return eZInputValidator::STATE_INVALID;
				}
			}
			else
			{
				// if the entered address is not empty then we should validate it in any case
				return $this->validateSwiftbicHTTPInput( $swiftbic, $contentObjectAttribute );
			}
		}
		else if ( !$classAttribute->attribute( 'is_information_collector' ) and $contentObjectAttribute->validateIsRequired() )
		{
			$contentObjectAttribute->setValidationError( ezi18n( 'kernel/classes/datatypes', 'Missing SWIFT - BIC code input.' ) );
			return eZInputValidator::STATE_INVALID;
		}

		return eZInputValidator::STATE_ACCEPTED;
	}

	function validateCollectionAttributeHTTPInput( $http, $base, $contentObjectAttribute )
	{
		if ( $http->hasPostVariable( $base . "_data_text_" . $contentObjectAttribute->attribute( "id" ) ) )
		{
			$swiftbic = $http->postVariable( $base . "_data_text_" . $contentObjectAttribute->attribute( "id" ) );
			$classAttribute = $contentObjectAttribute->contentClassAttribute();
		
			$swiftbic = trim( $swiftbic );
			if ( trim( $swiftbic ) == "" )
			{
				// if entered Swiftbic is empty and required then return state invalid
				if ( $contentObjectAttribute->validateIsRequired() )
				{
					$contentObjectAttribute->setValidationError( ezi18n( 'kernel/classes/datatypes','The SWIFT - BIC code is empty.' ) );
					return eZInputValidator::STATE_INVALID;
				}
				else
				return eZInputValidator::STATE_ACCEPTED;
			}
			else
			{
				// if entered Swiftbic is not empty then we should validate it in any case
				return $this->validateSwiftbicHTTPInput( $swiftbic, $contentObjectAttribute );
			}
		}
		else
		return eZInputValidator::STATE_INVALID;
	}

	/*!
	 Fetches the http post var string input and stores it in the data instance.
	 */
	function fetchObjectAttributeHTTPInput( $http, $base, $contentObjectAttribute )
	{
		if ( $http->hasPostVariable( $base . "_data_text_" . $contentObjectAttribute->attribute( "id" ) ) )
		{
			$data = $http->postVariable( $base . "_data_text_" . $contentObjectAttribute->attribute( "id" ) );
			$contentObjectAttribute->setAttribute( "data_text", $data );
			return true;
		}
		return false;
	}
	
    /*!
     Fetches the http post variables for collected information
    */
    function fetchCollectionAttributeHTTPInput( $collection, $collectionAttribute, $http, $base, $contentObjectAttribute )
    {
        if ( $http->hasPostVariable( $base . "_data_text_" . $contentObjectAttribute->attribute( "id" ) ) )
        {
            $dataText = $http->postVariable( $base . "_data_text_" . $contentObjectAttribute->attribute( "id" ) );
            $collectionAttribute->setAttribute( 'data_text', $dataText );
            return true;
        }
        return false;
    }

	function storeObjectAttribute( $contentObjectAttribute )
	{
	}

	function objectAttributeContent( $contentObjectAttribute )
	{
		return $contentObjectAttribute->attribute( 'data_text' );
	}

	function hasObjectAttributeContent( $contentObjectAttribute )
	{
		return trim( $contentObjectAttribute->attribute( "data_text" ) ) != '';
	}

	function isIndexable()
	{
		return true;
	}

	function isInformationCollector()
	{
		return true;
	}

	function sortKey( $contentObjectAttribute )
	{
		return strtolower( $contentObjectAttribute->attribute( 'data_text' ) );
	}

	function sortKeyType()
	{
		return 'string';
	}

	function supportsBatchInitializeObjectAttribute()
	{
		return true;
	}

    function fromString( $contentObjectAttribute, $string )
    {
        return $contentObjectAttribute->setAttribute( 'data_text', $string );
    }
    
	function title( $contentObjectAttribute, $name = null )
	{
		$content = $contentObjectAttribute->content();
		// Exit if the input is empty
		if( $content == '' )
		{
			return $content;
		}
		else
		{
			return $this->stripTags( $contentObjectAttribute, $content );
		}
	}

	function metaData( $contentObjectAttribute )
	{
		return $contentObjectAttribute->attribute( 'data_text' );
	}

	/*!
	 \return string representation of an contentobjectattribute data for simplified export
	 */
	function toString( $contentObjectAttribute )
	{
		return $contentObjectAttribute->attribute( 'data_text' );
	}

}
eZDataType::register( SwiftbicType::DATATYPE_STRING, "SwiftbicType" );

?>
