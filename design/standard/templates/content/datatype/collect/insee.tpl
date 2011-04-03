{default attribute_base=ContentObjectAttribute}
{let data_text=cond( is_set( $#collection_attributes[$attribute.id] ), $#collection_attributes[$attribute.id].data_text, $attribute.content )}
<input class="box" type="text" maxlength=15 size="20" name="{$attribute_base}_data_text_{$attribute.id}" value="{$data_text|wash( xhtml )}" />
{/let}
{/default}
