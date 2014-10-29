<?php
/**
 * Html class file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright 2008-2013 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */


/**
 * CHtml is a static class that provides a collection of helper methods for creating HTML views.
 *
 * Nearly all of the methods in this class allow setting additional html attributes for the html
 * tags they generate. You can specify for example. 'class', 'style'  or 'id' for an html element.
 * For example when using <code>array('class' => 'my-class', 'target' => '_blank')</code> as htmlOptions
 * it will result in the html attributes rendered like this: <code>class="my-class" target="_blank"</code>.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @package system.web.helpers
 * @since 1.0
 */
/**
 * This class was copied from Yii Framework 1.15 source code. 
 * Following modifications were done to make it compatible with Non Yii Projects:
 * - No support for Active Controls
 * - Error methods don't accept model(s) as argument instead they accept array of errors and key as attribute
 * - If an input control's name is set in $_REQUEST it is picked as value and supplied value is ignored
 * - No support for clientChange option in htmlOptions
 * - No javascript validation support
 * - Name was changed to Html
 */
class Html
{
	const ID_PREFIX='yt';
	/**
	 * @var string the CSS class for displaying error summaries (see {@link errorSummary}).
	 */
	public static $errorSummaryCss='errorSummary';
	/**
	 * @var string the CSS class for displaying error messages (see {@link error}).
	 */
	public static $errorMessageCss='errorMessage';
	/**
	 * @var string the CSS class for highlighting error inputs. Form inputs will be appended
	 * with this CSS class if they have input errors.
	 */
	public static $errorCss='error';
	/**
	 * @var string the tag name for the error container tag. Defaults to 'div'.
	 * @since 1.1.13
	 */
	public static $errorContainerTag='div';
	/**
	 * @var string the CSS class for required labels. Defaults to 'required'.
	 * @see label
	 */
	public static $requiredCss='required';
	/**
	 * @var string the HTML code to be prepended to the required label.
	 * @see label
	 */
	public static $beforeRequiredLabel='';
	/**
	 * @var string the HTML code to be appended to the required label.
	 * @see label
	 */
	public static $afterRequiredLabel=' <span class="required">*</span>';
	/**
	 * @var integer the counter for generating automatic input field names.
	 */
	public static $count=0;
	/**
	 * @var boolean whether to close single tags. Defaults to true. Can be set to false for HTML5.
	 * @since 1.1.13
	 */
	public static $closeSingleTags=true;
	/**
	 * @var boolean whether to render special attributes value. Defaults to true. Can be set to false for HTML5.
	 * @since 1.1.13
	 */
	public static $renderSpecialAttributesValue=true;
	/**
	 * @var Array of errors occured where key is name of attribute and value is error string
	 */
	public static $errors = [];

	/**
	 * Encodes special characters into HTML entities.
	 * The {@link CApplication::charset application charset} will be used for encoding.
	 * @param string $text data to be encoded
	 * @return string the encoded data
	 * @see http://www.php.net/manual/en/function.htmlspecialchars.php
	 */
	public static function encode($text)
	{
		return htmlspecialchars($text,ENT_QUOTES,'UTF-8');
	}

	/**
	 * Decodes special HTML entities back to the corresponding characters.
	 * This is the opposite of {@link encode()}.
	 * @param string $text data to be decoded
	 * @return string the decoded data
	 * @see http://www.php.net/manual/en/function.htmlspecialchars-decode.php
	 * @since 1.1.8
	 */
	public static function decode($text)
	{
		return htmlspecialchars_decode($text,ENT_QUOTES);
	}

	/**
	 * Encodes special characters in an array of strings into HTML entities.
	 * Both the array keys and values will be encoded if needed.
	 * If a value is an array, this method will also encode it recursively.
	 * The {@link CApplication::charset application charset} will be used for encoding.
	 * @param array $data data to be encoded
	 * @return array the encoded data
	 * @see http://www.php.net/manual/en/function.htmlspecialchars.php
	 */
	public static function encodeArray($data)
	{
		$d=array();
		foreach($data as $key=>$value)
		{
			if(is_string($key))
				$key=htmlspecialchars($key,ENT_QUOTES,'UTF-8');
			if(is_string($value))
				$value=htmlspecialchars($value,ENT_QUOTES,'UTF-8');
			elseif(is_array($value))
				$value=self::encodeArray($value);
			$d[$key]=$value;
		}
		return $d;
	}

	/**
	 * Generates an HTML element.
	 * @param string $tag the tag name
	 * @param array $htmlOptions the element attributes. The values will be HTML-encoded using {@link encode()}.
	 * If an 'encode' attribute is given and its value is false,
	 * the rest of the attribute values will NOT be HTML-encoded.
	 * Since version 1.1.5, attributes whose value is null will not be rendered.
	 * @param mixed $content the content to be enclosed between open and close element tags. It will not be HTML-encoded.
	 * If false, it means there is no body content.
	 * @param boolean $closeTag whether to generate the close tag.
	 * @return string the generated HTML element tag
	 */
	public static function tag($tag,$htmlOptions=array(),$content=false,$closeTag=true)
	{
		$html='<' . $tag . self::renderAttributes($htmlOptions);
		if($content===false)
			return $closeTag && self::$closeSingleTags ? $html.' />' : $html.'>';
		else
			return $closeTag ? $html.'>'.$content.'</'.$tag.'>' : $html.'>'.$content;
	}

	/**
	 * Generates an open HTML element.
	 * @param string $tag the tag name
	 * @param array $htmlOptions the element attributes. The values will be HTML-encoded using {@link encode()}.
	 * If an 'encode' attribute is given and its value is false,
	 * the rest of the attribute values will NOT be HTML-encoded.
	 * Since version 1.1.5, attributes whose value is null will not be rendered.
	 * @return string the generated HTML element tag
	 */
	public static function openTag($tag,$htmlOptions=array())
	{
		return '<' . $tag . self::renderAttributes($htmlOptions) . '>';
	}

	/**
	 * Generates a close HTML element.
	 * @param string $tag the tag name
	 * @return string the generated HTML element tag
	 */
	public static function closeTag($tag)
	{
		return '</'.$tag.'>';
	}

	/**
	 * Encloses the given string within a CDATA tag.
	 * @param string $text the string to be enclosed
	 * @return string the CDATA tag with the enclosed content.
	 */
	public static function cdata($text)
	{
		return '<![CDATA[' . $text . ']]>';
	}

	/**
	 * Generates a meta tag that can be inserted in the head section of HTML page.
	 * @param string $content content attribute of the meta tag
	 * @param string $name name attribute of the meta tag. If null, the attribute will not be generated
	 * @param string $httpEquiv http-equiv attribute of the meta tag. If null, the attribute will not be generated
	 * @param array $options other options in name-value pairs (e.g. 'scheme', 'lang')
	 * @return string the generated meta tag
	 */
	public static function metaTag($content,$name=null,$httpEquiv=null,$options=array())
	{
		if($name!==null)
			$options['name']=$name;
		if($httpEquiv!==null)
			$options['http-equiv']=$httpEquiv;
		$options['content']=$content;
		return self::tag('meta',$options);
	}

	/**
	 * Generates a link tag that can be inserted in the head section of HTML page.
	 * Do not confuse this method with {@link link()}. The latter generates a hyperlink.
	 * @param string $relation rel attribute of the link tag. If null, the attribute will not be generated.
	 * @param string $type type attribute of the link tag. If null, the attribute will not be generated.
	 * @param string $href href attribute of the link tag. If null, the attribute will not be generated.
	 * @param string $media media attribute of the link tag. If null, the attribute will not be generated.
	 * @param array $options other options in name-value pairs
	 * @return string the generated link tag
	 */
	public static function linkTag($relation=null,$type=null,$href=null,$media=null,$options=array())
	{
		if($relation!==null)
			$options['rel']=$relation;
		if($type!==null)
			$options['type']=$type;
		if($href!==null)
			$options['href']=$href;
		if($media!==null)
			$options['media']=$media;
		return self::tag('link',$options);
	}

	/**
	 * Encloses the given CSS content with a CSS tag.
	 * @param string $text the CSS content
	 * @param string $media the media that this CSS should apply to.
	 * @return string the CSS properly enclosed
	 */
	public static function css($text,$media='')
	{
		if($media!=='')
			$media=' media="'.$media.'"';
		return "<style type=\"text/css\"{$media}>\n/*<![CDATA[*/\n{$text}\n/*]]>*/\n</style>";
	}

	/**
	 * Links to the specified CSS file.
	 * @param string $url the CSS URL
	 * @param string $media the media that this CSS should apply to.
	 * @return string the CSS link.
	 */
	public static function cssFile($url,$media='')
	{
		return self::linkTag('stylesheet','text/css',$url,$media!=='' ? $media : null);
	}

	/**
	 * Encloses the given JavaScript within a script tag.
	 * @param string $text the JavaScript to be enclosed
	 * @param array $htmlOptions additional HTML attributes (see {@link tag})
	 * @return string the enclosed JavaScript
	 */
	public static function script($text,array $htmlOptions=array())
	{
		$defaultHtmlOptions=array(
			'type'=>'text/javascript',
		);
		$htmlOptions=array_merge($defaultHtmlOptions,$htmlOptions);
		return self::tag('script',$htmlOptions,"\n/*<![CDATA[*/\n{$text}\n/*]]>*/\n");
	}

	/**
	 * Includes a JavaScript file.
	 * @param string $url URL for the JavaScript file
	 * @param array $htmlOptions additional HTML attributes (see {@link tag})
	 * @return string the JavaScript file tag
	 */
	public static function scriptFile($url,array $htmlOptions=array())
	{
		$defaultHtmlOptions=array(
			'type'=>'text/javascript',
			'src'=>$url
		);
		$htmlOptions=array_merge($defaultHtmlOptions,$htmlOptions);
		return self::tag('script',$htmlOptions,'');
	}

	/**
	 * Generates an opening form tag.
	 * This is a shortcut to {@link beginForm}.
	 * @param mixed $action the form action URL (see {@link normalizeUrl} for details about this parameter.)
	 * @param string $method form method (e.g. post, get)
	 * @param array $htmlOptions additional HTML attributes (see {@link tag}).
	 * @return string the generated form tag.
	 */
	public static function form($action='',$method='post',$htmlOptions=array())
	{
		return self::beginForm($action,$method,$htmlOptions);
	}

	/**
	 * Generates an opening form tag.
	 * Note, only the open tag is generated. A close tag should be placed manually
	 * at the end of the form.
	 * @param mixed $action the form action URL (see {@link normalizeUrl} for details about this parameter.)
	 * @param string $method form method (e.g. post, get)
	 * @param array $htmlOptions additional HTML attributes (see {@link tag}).
	 * Special htmlOption supported:
	 * - file : adds multipart/form-data enctype to form and changes method to post
	 * @return string the generated form tag.
	 * @see endForm
	 */
	public static function beginForm($action='',$method='post',$htmlOptions=array())
	{
		$htmlOptions['action']=$url=self::normalizeUrl($action);
		if(strcasecmp($method,'get')!==0 && strcasecmp($method,'post')!==0)
		{
			$customMethod=$method;
			$method='post';
		}
		else
			$customMethod=false;

		$htmlOptions['method']=$method;

		if(isset($htmlOptions['file'])){
			$htmlOptions['method']="post";
			$htmlOptions['enctype']="multipart/form-data";
			unset($htmlOptions['file']);
		}

		$form=self::tag('form',$htmlOptions,false,false);
		$hiddens=array();
		if(!strcasecmp($method,'get') && ($pos=strpos($url,'?'))!==false)
		{
			foreach(explode('&',substr($url,$pos+1)) as $pair)
			{
				if(($pos=strpos($pair,'='))!==false)
					$hiddens[]=self::hiddenField(urldecode(substr($pair,0,$pos)),urldecode(substr($pair,$pos+1)),array('id'=>false));
				else
					$hiddens[]=self::hiddenField(urldecode($pair),'',array('id'=>false));
			}
		}
		if($customMethod!==false)
			$hiddens[]=self::hiddenField('_method',$customMethod);
		if($hiddens!==array())
			$form.="\n".implode("\n",$hiddens);
		return $form;
	}

	/**
	 * Generates a closing form tag.
	 * @return string the generated tag
	 * @see beginForm
	 */
	public static function endForm()
	{
		return '</form>';
	}

	/**
	 * Generates a hyperlink tag.
	 * @param string $text link body. It will NOT be HTML-encoded. Therefore you can pass in HTML code such as an image tag.
	 * @param mixed $url a URL or an action route that can be used to create a URL.
	 * See {@link normalizeUrl} for more details about how to specify this parameter.
	 * @param array $htmlOptions additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * @return string the generated hyperlink
	 * @see normalizeUrl
	 * @see clientChange
	 */
	public static function link($text,$url='#',$htmlOptions=array())
	{
		if($url!=='')
			$htmlOptions['href']=self::normalizeUrl($url);
		return self::tag('a',$htmlOptions,$text);
	}

	/**
	 * Generates a mailto link.
	 * @param string $text link body. It will NOT be HTML-encoded. Therefore you can pass in HTML code such as an image tag.
	 * @param string $email email address. If this is empty, the first parameter (link body) will be treated as the email address.
	 * @param array $htmlOptions additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * @return string the generated mailto link
	 * @see clientChange
	 */
	public static function mailto($text,$email='',$htmlOptions=array())
	{
		if($email==='')
			$email=$text;
		return self::link($text,'mailto:'.$email,$htmlOptions);
	}

	/**
	 * Generates an image tag.
	 * @param string $src the image URL
	 * @param string $alt the alternative text display
	 * @param array $htmlOptions additional HTML attributes (see {@link tag}).
	 * @return string the generated image tag
	 */
	public static function image($src,$alt='',$htmlOptions=array())
	{
		$htmlOptions['src']=$src;
		$htmlOptions['alt']=$alt;
		return self::tag('img',$htmlOptions);
	}

	/**
	 * Generates a button.
	 * @param string $label the button label
	 * @param array $htmlOptions additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * @return string the generated button tag
	 * @see clientChange
	 */
	public static function button($label='button',$htmlOptions=array())
	{
		if(!isset($htmlOptions['name']))
		{
			if(!array_key_exists('name',$htmlOptions))
				$htmlOptions['name']=self::ID_PREFIX.self::$count++;
		}
		if(!isset($htmlOptions['type']))
			$htmlOptions['type']='button';
		if(!isset($htmlOptions['value']) && $htmlOptions['type']!='image')
			$htmlOptions['value']=$label;
		return self::tag('input',$htmlOptions);
	}

	/**
	 * Generates a button using HTML button tag.
	 * This method is similar to {@link button} except that it generates a 'button'
	 * tag instead of 'input' tag.
	 * @param string $label the button label. Note that this value will be directly inserted in the button element
	 * without being HTML-encoded.
	 * @param array $htmlOptions additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * @return string the generated button tag
	 * @see clientChange
	 */
	public static function htmlButton($label='button',$htmlOptions=array())
	{
		if(!isset($htmlOptions['name']))
			$htmlOptions['name']=self::ID_PREFIX.self::$count++;
		if(!isset($htmlOptions['type']))
			$htmlOptions['type']='button';
		return self::tag('button',$htmlOptions,$label);
	}

	/**
	 * Generates a submit button.
	 * @param string $label the button label
	 * @param array $htmlOptions additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * @return string the generated button tag
	 * @see clientChange
	 */
	public static function submitButton($label='submit',$htmlOptions=array())
	{
		$htmlOptions['type']='submit';
		return self::button($label,$htmlOptions);
	}

	/**
	 * Generates a reset button.
	 * @param string $label the button label
	 * @param array $htmlOptions additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * @return string the generated button tag
	 * @see clientChange
	 */
	public static function resetButton($label='reset',$htmlOptions=array())
	{
		$htmlOptions['type']='reset';
		return self::button($label,$htmlOptions);
	}

	/**
	 * Generates an image submit button.
	 * @param string $src the image URL
	 * @param array $htmlOptions additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * @return string the generated button tag
	 * @see clientChange
	 */
	public static function imageButton($src,$htmlOptions=array())
	{
		$htmlOptions['src']=$src;
		$htmlOptions['type']='image';
		return self::button('submit',$htmlOptions);
	}

	/**
	 * Generates a link submit button.
	 * @param string $label the button label
	 * @param array $htmlOptions additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * @return string the generated button tag
	 * @see clientChange
	 */
	public static function linkButton($label='submit',$htmlOptions=array())
	{
		if(!isset($htmlOptions['submit']))
			$htmlOptions['submit']=isset($htmlOptions['href']) ? $htmlOptions['href'] : '';
		return self::link($label,'#',$htmlOptions);
	}

	/**
	 * Generates a label tag.
	 * @param string $label label text. Note, you should HTML-encode the text if needed.
	 * @param string $for the ID of the HTML element that this label is associated with.
	 * If this is false, the 'for' attribute for the label tag will not be rendered.
	 * @param array $htmlOptions additional HTML attributes.
	 * The following HTML option is recognized:
	 * <ul>
	 * <li>required: if this is set and is true, the label will be styled
	 * with CSS class 'required' (customizable with CHtml::$requiredCss),
	 * and be decorated with {@link CHtml::beforeRequiredLabel} and
	 * {@link CHtml::afterRequiredLabel}.</li>
	 * </ul>
	 * @return string the generated label tag
	 */
	public static function label($label,$for,$htmlOptions=array())
	{
		if($for===false)
			unset($htmlOptions['for']);
		else
			$htmlOptions['for']=self::getIdByName($for);
		if(isset($htmlOptions['required']))
		{
			if($htmlOptions['required'])
			{
				if(isset($htmlOptions['class']))
					$htmlOptions['class'].=' '.self::$requiredCss;
				else
					$htmlOptions['class']=self::$requiredCss;
				$label=self::$beforeRequiredLabel.$label.self::$afterRequiredLabel;
			}
			unset($htmlOptions['required']);
		}
		return self::tag('label',$htmlOptions,$label);
	}

	/**
	 * Generates a color picker field input.
	 * @param string $name the input name
	 * @param string $value the input value
	 * @param array $htmlOptions additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * @return string the generated input field
	 * @see clientChange
	 * @see inputField
	 * @since 1.1.15
	 */
	public static function colorField($name,$value='',$htmlOptions=array())
	{
		return self::inputField('color',$name,$value,$htmlOptions);
	}

	/**
	 * Generates a text field input.
	 * @param string $name the input name
	 * @param string $value the input value
	 * @param array $htmlOptions additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * @return string the generated input field
	 * @see clientChange
	 * @see inputField
	 */
	public static function textField($name,$value='',$htmlOptions=array())
	{
		return self::inputField('text',$name,$value,$htmlOptions);
	}

	/**
	 * Generates a search field input.
	 * @param string $name the input name
	 * @param string $value the input value
	 * @param array $htmlOptions additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * @return string the generated input field
	 * @see clientChange
	 * @see inputField
	 * @since 1.1.15
	 */
	public static function searchField($name,$value='',$htmlOptions=array())
	{
		return self::inputField('search',$name,$value,$htmlOptions);
	}
	/**
	 * Generates a number field input.
	 * @param string $name the input name
	 * @param string $value the input value
	 * @param array $htmlOptions additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * @return string the generated input field
	 * @see clientChange
	 * @see inputField
	 * @since 1.1.14
	 */
	public static function numberField($name,$value='',$htmlOptions=array())
	{
		return self::inputField('number',$name,$value,$htmlOptions);
	}

	/**
	 * Generates a range field input.
	 * @param string $name the input name
	 * @param string $value the input value
	 * @param array $htmlOptions additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * @return string the generated input field
	 * @see clientChange
	 * @see inputField
	 * @since 1.1.14
	 */
	public static function rangeField($name,$value='',$htmlOptions=array())
	{
		return self::inputField('range',$name,$value,$htmlOptions);
	}

	/**
	 * Generates a date field input.
	 * @param string $name the input name
	 * @param string $value the input value
	 * @param array $htmlOptions additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * @return string the generated input field
	 * @see clientChange
	 * @see inputField
	 * @since 1.1.14
	 */
	public static function dateField($name,$value='',$htmlOptions=array())
	{
		return self::inputField('date',$name,$value,$htmlOptions);
	}

	/**
	 * Generates a time field input.
	 * @param string $name the input name
	 * @param string $value the input value
	 * @param array $htmlOptions additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * @return string the generated input field
	 * @see clientChange
	 * @see inputField
	 * @since 1.1.14
	 */
	public static function timeField($name,$value='',$htmlOptions=array())
	{
		return self::inputField('time',$name,$value,$htmlOptions);
	}

	/**
	 * Generates a datetime field input.
	 * @param string $name the input name
	 * @param string $value the input value
	 * @param array $htmlOptions additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * @return string the generated input field
	 * @see clientChange
	 * @see inputField
	 * @since 1.1.15
	 */
	public static function dateTimeField($name,$value='',$htmlOptions=array())
	{
		return self::inputField('datetime',$name,$value,$htmlOptions);
	}

	/**
	 * Generates a local datetime field input.
	 * @param string $name the input name
	 * @param string $value the input value
	 * @param array $htmlOptions additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * @return string the generated input field
	 * @see clientChange
	 * @see inputField
	 * @since 1.1.15
	 */
	public static function dateTimeLocalField($name,$value='',$htmlOptions=array())
	{
		return self::inputField('datetime-local',$name,$value,$htmlOptions);
	}

	/**
	 * Generates a week field input.
	 * @param string $name the input name
	 * @param string $value the input value
	 * @param array $htmlOptions additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * @return string the generated input field
	 * @see clientChange
	 * @see inputField
	 * @since 1.1.15
	 */
	public static function weekField($name,$value='',$htmlOptions=array())
	{
		return self::inputField('week',$name,$value,$htmlOptions);
	}

	/**
	 * Generates an email field input.
	 * @param string $name the input name
	 * @param string $value the input value
	 * @param array $htmlOptions additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * @return string the generated input field
	 * @see clientChange
	 * @see inputField
	 * @since 1.1.14
	 */
	public static function emailField($name,$value='',$htmlOptions=array())
	{
		return self::inputField('email',$name,$value,$htmlOptions);
	}

	/**
	 * Generates a telephone field input.
	 * @param string $name the input name
	 * @param string $value the input value
	 * @param array $htmlOptions additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * @return string the generated input field
	 * @see clientChange
	 * @see inputField
	 * @since 1.1.14
	 */
	public static function telField($name,$value='',$htmlOptions=array())
	{
		return self::inputField('tel',$name,$value,$htmlOptions);
	}

	/**
	 * Generates a URL field input.
	 * @param string $name the input name
	 * @param string $value the input value
	 * @param array $htmlOptions additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * @return string the generated input field
	 * @see clientChange
	 * @see inputField
	 * @since 1.1.14
	 */
	public static function urlField($name,$value='',$htmlOptions=array())
	{
		return self::inputField('url',$name,$value,$htmlOptions);
	}

	/**
	 * Generates a hidden input.
	 * @param string $name the input name
	 * @param string $value the input value
	 * @param array $htmlOptions additional HTML attributes (see {@link tag}).
	 * @return string the generated input field
	 * @see inputField
	 */
	public static function hiddenField($name,$value='',$htmlOptions=array())
	{
		return self::inputField('hidden',$name,$value,$htmlOptions);
	}

	/**
	 * Generates a password field input.
	 * @param string $name the input name
	 * @param string $value the input value
	 * @param array $htmlOptions additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * @return string the generated input field
	 * @see clientChange
	 * @see inputField
	 */
	public static function passwordField($name,$value='',$htmlOptions=array())
	{
		return self::inputField('password',$name,$value,$htmlOptions);
	}

	/**
	 * Generates a file input.
	 * Note, you have to set the enclosing form's 'enctype' attribute to be 'multipart/form-data'.
	 * After the form is submitted, the uploaded file information can be obtained via $_FILES[$name] (see
	 * PHP documentation).
	 * @param string $name the input name
	 * @param string $value the input value
	 * @param array $htmlOptions additional HTML attributes (see {@link tag}).
	 * @return string the generated input field
	 * @see inputField
	 */
	public static function fileField($name,$value='',$htmlOptions=array())
	{
		return self::inputField('file',$name,$value,$htmlOptions);
	}

	/**
	 * Generates a text area input.
	 * @param string $name the input name
	 * @param string $value the input value
	 * @param array $htmlOptions additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * @return string the generated text area
	 * @see clientChange
	 * @see inputField
	 */
	public static function textArea($name,$value='',$htmlOptions=array())
	{
		if(isset($_REQUEST[$name])){
			$value = $_REQUEST[$name];
		}
		//is two dimensional
		elseif(preg_match("/(\w+)\[(\w+)\]/", $name, $matches)){
			if(isset($_REQUEST[$matches[1]][$matches[2]])){
			$value = $_REQUEST[$matches[1]][$matches[2]];
			}
		}
		$htmlOptions['name']=$name;
		if(!isset($htmlOptions['id']))
			$htmlOptions['id']=self::getIdByName($name);
		elseif($htmlOptions['id']===false)
			unset($htmlOptions['id']);
		return self::tag('textarea',$htmlOptions,isset($htmlOptions['encode']) && !$htmlOptions['encode'] ? $value : self::encode($value));
	}

	/**
	 * Generates a radio button.
	 * @param string $name the input name
	 * @param boolean $checked whether the radio button is checked
	 * @param array $htmlOptions additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * Since version 1.1.2, a special option named 'uncheckValue' is available that can be used to specify
	 * the value returned when the radio button is not checked. When set, a hidden field is rendered so that
	 * when the radio button is not checked, we can still obtain the posted uncheck value.
	 * If 'uncheckValue' is not set or set to NULL, the hidden field will not be rendered.
	 * @return string the generated radio button
	 * @see clientChange
	 * @see inputField
	 */
	public static function radioButton($name,$checked=false,$htmlOptions=array())
	{
		$value=isset($htmlOptions['value']) ? $htmlOptions['value'] : 1;

		if($checked || (isset($_REQUEST[$name]) && $_REQUEST[$name] == $value))
			$htmlOptions['checked']='checked';
		else
			unset($htmlOptions['checked']);

		if(array_key_exists('uncheckValue',$htmlOptions))
		{
			$uncheck=$htmlOptions['uncheckValue'];
			unset($htmlOptions['uncheckValue']);
		}
		else
			$uncheck=null;

		if($uncheck!==null)
		{
			// add a hidden field so that if the radio button is not selected, it still submits a value
			if(isset($htmlOptions['id']) && $htmlOptions['id']!==false)
				$uncheckOptions=array('id'=>self::ID_PREFIX.$htmlOptions['id']);
			else
				$uncheckOptions=array('id'=>false);
			$hidden=self::hiddenField($name,$uncheck,$uncheckOptions);
		}
		else
			$hidden='';

		// add a hidden field so that if the radio button is not selected, it still submits a value
		return $hidden . self::inputField('radio',$name,$value,$htmlOptions);
	}

	/**
	 * Generates a check box.
	 * @param string $name the input name
	 * @param boolean $checked whether the check box is checked
	 * @param array $htmlOptions additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * Since version 1.1.2, a special option named 'uncheckValue' is available that can be used to specify
	 * the value returned when the checkbox is not checked. When set, a hidden field is rendered so that
	 * when the checkbox is not checked, we can still obtain the posted uncheck value.
	 * If 'uncheckValue' is not set or set to NULL, the hidden field will not be rendered.
	 * @return string the generated check box
	 * @see clientChange
	 * @see inputField
	 */
	public static function checkBox($name,$checked=false,$htmlOptions=array())
	{
		$value=isset($htmlOptions['value']) ? $htmlOptions['value'] : 1;
		if($checked || (isset($_REQUEST[$name]) && ($_REQUEST[$name] == $value || in_array($value, $_REQUEST[$name]))))
			$htmlOptions['checked']='checked';
		else
			unset($htmlOptions['checked']);

		if(array_key_exists('uncheckValue',$htmlOptions))
		{
			$uncheck=$htmlOptions['uncheckValue'];
			unset($htmlOptions['uncheckValue']);
		}
		else
			$uncheck=null;

		if($uncheck!==null)
		{
			// add a hidden field so that if the check box is not checked, it still submits a value
			if(isset($htmlOptions['id']) && $htmlOptions['id']!==false)
				$uncheckOptions=array('id'=>self::ID_PREFIX.$htmlOptions['id']);
			else
				$uncheckOptions=array('id'=>false);
			$hidden=self::hiddenField($name,$uncheck,$uncheckOptions);
		}
		else
			$hidden='';

		// add a hidden field so that if the check box is not checked, it still submits a value
		return $hidden . self::inputField('checkbox',$name,$value,$htmlOptions);
	}

	/**
	 * Generates a drop down list.
	 * @param string $name the input name
	 * @param string $select the selected value
	 * @param array $data data for generating the list options (value=>display).
	 * You may use {@link listData} to generate this data.
	 * Please refer to {@link listOptions} on how this data is used to generate the list options.
	 * Note, the values and labels will be automatically HTML-encoded by this method.
	 * @param array $htmlOptions additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are recognized. See {@link clientChange} and {@link tag} for more details.
	 * In addition, the following options are also supported specifically for dropdown list:
	 * <ul>
	 * <li>encode: boolean, specifies whether to encode the values. Defaults to true.</li>
	 * <li>prompt: string, specifies the prompt text shown as the first list option. Its value is empty. Note, the prompt text will NOT be HTML-encoded.</li>
	 * <li>empty: string, specifies the text corresponding to empty selection. Its value is empty.
	 * The 'empty' option can also be an array of value-label pairs.
	 * Each pair will be used to render a list option at the beginning. Note, the text label will NOT be HTML-encoded.</li>
	 * <li>options: array, specifies additional attributes for each OPTION tag.
	 *     The array keys must be the option values, and the array values are the extra
	 *     OPTION tag attributes in the name-value pairs. For example,
	 * <pre>
	 *     array(
	 *         'value1'=>array('disabled'=>true,'label'=>'value 1'),
	 *         'value2'=>array('label'=>'value 2'),
	 *     );
	 * </pre>
	 * </li>
	 * </ul>
	 * Since 1.1.13, a special option named 'unselectValue' is available. It can be used to set the value
	 * that will be returned when no option is selected in multiple mode. When set, a hidden field is
	 * rendered so that if no option is selected in multiple mode, we can still obtain the posted
	 * unselect value. If 'unselectValue' is not set or set to NULL, the hidden field will not be rendered.
	 * @return string the generated drop down list
	 * @see clientChange
	 * @see inputField
	 * @see listData
	 */
	public static function dropDownList($name,$select,$data,$htmlOptions=array())
	{
		$htmlOptions['name']=$name;

		if(!isset($htmlOptions['id']))
			$htmlOptions['id']=self::getIdByName($name);
		elseif($htmlOptions['id']===false)
			unset($htmlOptions['id']);

		$options="\n".self::listOptions($select,$data,$htmlOptions);
		$hidden='';

		if(!empty($htmlOptions['multiple']))
		{
			if(substr($htmlOptions['name'],-2)!=='[]')
				$htmlOptions['name'].='[]';

			if(isset($htmlOptions['unselectValue']))
			{
				$hiddenOptions=isset($htmlOptions['id']) ? array('id'=>self::ID_PREFIX.$htmlOptions['id']) : array('id'=>false);
				$hidden=self::hiddenField(substr($htmlOptions['name'],0,-2),$htmlOptions['unselectValue'],$hiddenOptions);
				unset($htmlOptions['unselectValue']);
			}
		}
		// add a hidden field so that if the option is not selected, it still submits a value
		return $hidden . self::tag('select',$htmlOptions,$options);
	}

	/**
	 * Generates a list box.
	 * @param string $name the input name
	 * @param mixed $select the selected value(s). This can be either a string for single selection or an array for multiple selections.
	 * @param array $data data for generating the list options (value=>display)
	 * You may use {@link listData} to generate this data.
	 * Please refer to {@link listOptions} on how this data is used to generate the list options.
	 * Note, the values and labels will be automatically HTML-encoded by this method.
	 * @param array $htmlOptions additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized. See {@link clientChange} and {@link tag} for more details.
	 * In addition, the following options are also supported specifically for list box:
	 * <ul>
	 * <li>encode: boolean, specifies whether to encode the values. Defaults to true.</li>
	 * <li>prompt: string, specifies the prompt text shown as the first list option. Its value is empty. Note, the prompt text will NOT be HTML-encoded.</li>
	 * <li>empty: string, specifies the text corresponding to empty selection. Its value is empty.
	 * The 'empty' option can also be an array of value-label pairs.
	 * Each pair will be used to render a list option at the beginning. Note, the text label will NOT be HTML-encoded.</li>
	 * <li>options: array, specifies additional attributes for each OPTION tag.
	 *     The array keys must be the option values, and the array values are the extra
	 *     OPTION tag attributes in the name-value pairs. For example,
	 * <pre>
	 *     array(
	 *         'value1'=>array('disabled'=>true,'label'=>'value 1'),
	 *         'value2'=>array('label'=>'value 2'),
	 *     );
	 * </pre>
	 * </li>
	 * </ul>
	 * @return string the generated list box
	 * @see clientChange
	 * @see inputField
	 * @see listData
	 */
	public static function listBox($name,$select,$data,$htmlOptions=array())
	{
		if(!isset($htmlOptions['size']))
			$htmlOptions['size']=4;
		if(!empty($htmlOptions['multiple']))
		{
			if(substr($name,-2)!=='[]')
				$name.='[]';
		}
		return self::dropDownList($name,$select,$data,$htmlOptions);
	}

	/**
	 * Generates a check box list.
	 * A check box list allows multiple selection, like {@link listBox}.
	 * As a result, the corresponding POST value is an array.
	 * @param string $name name of the check box list. You can use this name to retrieve
	 * the selected value(s) once the form is submitted.
	 * @param mixed $select selection of the check boxes. This can be either a string
	 * for single selection or an array for multiple selections.
	 * @param array $data value-label pairs used to generate the check box list.
	 * Note, the values will be automatically HTML-encoded, while the labels will not.
	 * @param array $htmlOptions additional HTML options. The options will be applied to
	 * each checkbox input. The following special options are recognized:
	 * <ul>
	 * <li>template: string, specifies how each checkbox is rendered. Defaults
	 * to "{input} {label}", where "{input}" will be replaced by the generated
	 * check box input tag while "{label}" be replaced by the corresponding check box label,
	 * {beginLabel} will be replaced by &lt;label&gt; with labelOptions, {labelTitle} will be replaced
	 * by the corresponding check box label title and {endLabel} will be replaced by &lt;/label&gt;</li>
	 * <li>separator: string, specifies the string that separates the generated check boxes.</li>
	 * <li>labelOptions: array, specifies the additional HTML attributes to be rendered
	 * for every label tag in the list.</li>
	 * <li>container: string, specifies the checkboxes enclosing tag. Defaults to 'span'.
	 * If the value is an empty string, no enclosing tag will be generated</li>
	 * <li>baseID: string, specifies the base ID prefix to be used for checkboxes in the list.
	 * This option is available since version 1.1.13.</li>
	 * </ul>
	 * @return string the generated check box list
	 */
	public static function checkBoxList($name,$select,$data,$htmlOptions=array())
	{
		$template=isset($htmlOptions['template'])?$htmlOptions['template']:'{input} {label}';
		$separator=isset($htmlOptions['separator'])?$htmlOptions['separator']:self::tag('br');
		$container=isset($htmlOptions['container'])?$htmlOptions['container']:'span';
		unset($htmlOptions['template'],$htmlOptions['separator'],$htmlOptions['container']);

		if(substr($name,-2)!=='[]')
			$name.='[]';

		$labelOptions=isset($htmlOptions['labelOptions'])?$htmlOptions['labelOptions']:array();
		unset($htmlOptions['labelOptions']);

		$items=array();
		$baseID=isset($htmlOptions['baseID']) ? $htmlOptions['baseID'] : self::getIdByName($name);
		unset($htmlOptions['baseID']);
		$id=0;
		$checkAll=true;

		foreach($data as $value=>$labelTitle)
		{
			$checked=!is_array($select) && !strcmp($value,$select) || is_array($select) && in_array($value,$select);
			$htmlOptions['value']=$value;
			$htmlOptions['id']=$baseID.'_'.$id++;
			$option=self::checkBox($name,$checked,$htmlOptions);
			$beginLabel=self::openTag('label',$labelOptions);
			$label=self::label($labelTitle,$htmlOptions['id'],$labelOptions);
			$endLabel=self::closeTag('label');
			$items[]=strtr($template,array(
				'{input}'=>$option,
				'{beginLabel}'=>$beginLabel,
				'{label}'=>$label,
				'{labelTitle}'=>$labelTitle,
				'{endLabel}'=>$endLabel,
			));
		}

		if(empty($container))
			return implode($separator,$items);
		else
			return self::tag($container,array('id'=>$baseID),implode($separator,$items));
	}

	/**
	 * Generates a radio button list.
	 * A radio button list is like a {@link checkBoxList check box list}, except that
	 * it only allows single selection.
	 * @param string $name name of the radio button list. You can use this name to retrieve
	 * the selected value(s) once the form is submitted.
	 * @param string $select selection of the radio buttons.
	 * @param array $data value-label pairs used to generate the radio button list.
	 * Note, the values will be automatically HTML-encoded, while the labels will not.
	 * @param array $htmlOptions additional HTML options. The options will be applied to
	 * each radio button input. The following special options are recognized:
	 * <ul>
	 * <li>template: string, specifies how each radio button is rendered. Defaults
	 * to "{input} {label}", where "{input}" will be replaced by the generated
	 * radio button input tag while "{label}" will be replaced by the corresponding radio button label,
	 * {beginLabel} will be replaced by &lt;label&gt; with labelOptions, {labelTitle} will be replaced
	 * by the corresponding radio button label title and {endLabel} will be replaced by &lt;/label&gt;</li>
	 * <li>separator: string, specifies the string that separates the generated radio buttons. Defaults to new line (<br/>).</li>
	 * <li>labelOptions: array, specifies the additional HTML attributes to be rendered
	 * for every label tag in the list.</li>
	 * <li>container: string, specifies the radio buttons enclosing tag. Defaults to 'span'.
	 * If the value is an empty string, no enclosing tag will be generated</li>
	 * <li>baseID: string, specifies the base ID prefix to be used for radio buttons in the list.
	 * This option is available since version 1.1.13.</li>
	 * <li>empty: string, specifies the text corresponding to empty selection. Its value is empty.
	 * The 'empty' option can also be an array of value-label pairs.
	 * Each pair will be used to render a radio button at the beginning. Note, the text label will NOT be HTML-encoded.
	 * This option is available since version 1.1.14.</li>
	 * </ul>
	 * @return string the generated radio button list
	 */
	public static function radioButtonList($name,$select,$data,$htmlOptions=array())
	{
		$template=isset($htmlOptions['template'])?$htmlOptions['template']:'{input} {label}';
		$separator=isset($htmlOptions['separator'])?$htmlOptions['separator']:self::tag('br');
		$container=isset($htmlOptions['container'])?$htmlOptions['container']:'span';
		unset($htmlOptions['template'],$htmlOptions['separator'],$htmlOptions['container']);

		$labelOptions=isset($htmlOptions['labelOptions'])?$htmlOptions['labelOptions']:array();
		unset($htmlOptions['labelOptions']);

		if(isset($htmlOptions['empty']))
		{
			if(!is_array($htmlOptions['empty']))
				$htmlOptions['empty']=array(''=>$htmlOptions['empty']);
			$data=TMap::mergeArray($htmlOptions['empty'],$data);
			unset($htmlOptions['empty']);
		}

		$items=array();
		$baseID=isset($htmlOptions['baseID']) ? $htmlOptions['baseID'] : self::getIdByName($name);
		unset($htmlOptions['baseID']);
		$id=0;
		foreach($data as $value=>$labelTitle)
		{
			$checked=!strcmp($value,$select);
			$htmlOptions['value']=$value;
			$htmlOptions['id']=$baseID.'_'.$id++;
			$option=self::radioButton($name,$checked,$htmlOptions);
			$beginLabel=self::openTag('label',$labelOptions);
			$label=self::label($labelTitle,$htmlOptions['id'],$labelOptions);
			$endLabel=self::closeTag('label');
			$items[]=strtr($template,array(
				'{input}'=>$option,
				'{beginLabel}'=>$beginLabel,
				'{label}'=>$label,
				'{labelTitle}'=>$labelTitle,
				'{endLabel}'=>$endLabel,
			));
		}
		if(empty($container))
			return implode($separator,$items);
		else
			return self::tag($container,array('id'=>$baseID),implode($separator,$items));
	}

	/**
	 * Normalizes the input parameter to be a valid URL.
	 *
	 * If the input parameter is an empty string, the currently requested URL will be returned.
	 *
	 * If the input parameter is a non-empty string, it is treated as a valid URL and will
	 * be returned without any change.
	 *
	 * If the input parameter is an array, it is treated as a controller route and a list of
	 * GET parameters, and the {@link CController::createUrl} method will be invoked to
	 * create a URL. In this case, the first array element refers to the controller route,
	 * and the rest key-value pairs refer to the additional GET parameters for the URL.
	 * For example, <code>array('post/list', 'page'=>3)</code> may be used to generate the URL
	 * <code>/index.php?r=post/list&page=3</code>.
	 *
	 * @param mixed $url the parameter to be used to generate a valid URL
	 * @return string the normalized URL
	 */
	public static function normalizeUrl($url)
	{
		return $url;
	}

	/**
	 * Generates an input HTML tag.
	 * This method generates an input HTML tag based on the given input name and value.
	 * @param string $type the input type (e.g. 'text', 'radio')
	 * @param string $name the input name
	 * @param string $value the input value
	 * @param array $htmlOptions additional HTML attributes for the HTML tag (see {@link tag}).
	 * @return string the generated input tag
	 */
	protected static function inputField($type,$name,$value,$htmlOptions)
	{
		$htmlOptions['type']=$type;
		if(!in_array($type, ['password', 'radio', 'checkbox'])){
			if(isset($_REQUEST[$name])){
				$value = $_REQUEST[$name];
			}
			//is two dimensional
			elseif(preg_match("/(\w+)\[(\w+)\]/", $name, $matches)){
				if(isset($_REQUEST[$matches[1]][$matches[2]])){
					$value = $_REQUEST[$matches[1]][$matches[2]];
				}
			}
		}
		$htmlOptions['value']= $value;
		$htmlOptions['name']=$name;
		if(!isset($htmlOptions['id']))
			$htmlOptions['id']=self::getIdByName($name);
		elseif($htmlOptions['id']===false)
			unset($htmlOptions['id']);
		return self::tag('input',$htmlOptions);
	}

	/**
	 * Displays a summary of validation errors for one or several models.
	 * @param string $header a piece of HTML code that appears in front of the errors
	 * @param string $footer a piece of HTML code that appears at the end of the errors
	 * @param array $htmlOptions additional HTML attributes to be rendered in the container div tag.
	 * A special option named 'firstError' is recognized, which when set true, will
	 * make the error summary to show only the first error message of each attribute.
	 * If this is not set or is false, all error messages will be displayed.
	 * This option has been available since version 1.1.3.
	 * @return string the error summary. Empty if no errors are found.
	 * @see errorSummaryCss
	 */
	public static function errorSummary($header=null,$footer=null,$htmlOptions=array())
	{
		$content='';
		foreach(self::$errors as $error)
		{
			if($error!='')
				$content.="<li>$error</li>\n";
		}
		if($content!=='')
		{
			if($header===null)
				$header='<p>Please fix the following input errors:</p>';
			if(!isset($htmlOptions['class']))
				$htmlOptions['class']=self::$errorSummaryCss;
			return self::tag('div',$htmlOptions,$header."\n<ul>\n$content</ul>".$footer);
		}
		else
			return '';
	}

	/**
	 * Displays the first validation error for a model attribute.
	 * @param array $error string error
	 * @param string $attribute the attribute name
	 * @param array $htmlOptions additional HTML attributes to be rendered in the container tag.
	 * @return string the error display. Empty if no errors are found.
	 * @see CModel::getErrors
	 * @see errorMessageCss
	 * @see $errorContainerTag
	 */
	public static function error($attribute,$htmlOptions=array())
	{
		$error = '';
		if(isset(self::$errors[$attribute])){
			$error = self::$errors[$attribute];
		}
		if($error!='')
		{
			if(!isset($htmlOptions['class']))
				$htmlOptions['class']=self::$errorMessageCss;
			return self::tag(self::$errorContainerTag,$htmlOptions,$error);
		}
		else
			return '';
	}

	/**
	 * Generates a valid HTML ID based on name.
	 * @param string $name name from which to generate HTML ID
	 * @return string the ID generated based on name.
	 */
	public static function getIdByName($name)
	{
		return str_replace(array('[]','][','[',']',' '),array('','_','_','','_'),$name);
	}

	/**
	 * Generates the list options.
	 * @param mixed $selection the selected value(s). This can be either a string for single selection or an array for multiple selections.
	 * @param array $listData the option data (see {@link listData})
	 * @param array $htmlOptions additional HTML attributes. The following two special attributes are recognized:
	 * <ul>
	 * <li>encode: boolean, specifies whether to encode the values. Defaults to true.</li>
	 * <li>prompt: string, specifies the prompt text shown as the first list option. Its value is empty. Note, the prompt text will NOT be HTML-encoded.</li>
	 * <li>empty: string, specifies the text corresponding to empty selection. Its value is empty.
	 * The 'empty' option can also be an array of value-label pairs.
	 * Each pair will be used to render a list option at the beginning. Note, the text label will NOT be HTML-encoded.</li>
	 * <li>options: array, specifies additional attributes for each OPTION tag.
	 *     The array keys must be the option values, and the array values are the extra
	 *     OPTION tag attributes in the name-value pairs. For example,
	 * <pre>
	 *     array(
	 *         'value1'=>array('disabled'=>true,'label'=>'value 1'),
	 *         'value2'=>array('label'=>'value 2'),
	 *     );
	 * </pre>
	 * </li>
	 * <li>key: string, specifies the name of key attribute of the selection object(s).
	 * This is used when the selection is represented in terms of objects. In this case,
	 * the property named by the key option of the objects will be treated as the actual selection value.
	 * This option defaults to 'primaryKey', meaning using the 'primaryKey' property value of the objects in the selection.
	 * This option has been available since version 1.1.3.</li>
	 * </ul>
	 * @return string the generated list options
	 */
	public static function listOptions($selection,$listData,&$htmlOptions)
	{
		$name = $htmlOptions['name'];
		if(isset($_REQUEST[$name])){
			$selection = (array) $_REQUEST[$name];
		}//is two dimensional
		elseif(preg_match("/(\w+)\[(\w+)\]/", $name, $matches)){
			if(isset($_REQUEST[$matches[1]][$matches[2]])){
				$selection = (array) $_REQUEST[$matches[1]][$matches[2]];
			}
		}
		$raw=isset($htmlOptions['encode']) && !$htmlOptions['encode'];
		$content='';
		if(isset($htmlOptions['prompt']))
		{
			$content.='<option value="">'.strtr($htmlOptions['prompt'],array('<'=>'&lt;','>'=>'&gt;'))."</option>\n";
			unset($htmlOptions['prompt']);
		}
		if(isset($htmlOptions['empty']))
		{
			if(!is_array($htmlOptions['empty']))
				$htmlOptions['empty']=array(''=>$htmlOptions['empty']);
			foreach($htmlOptions['empty'] as $value=>$label)
				$content.='<option value="'.self::encode($value).'">'.strtr($label,array('<'=>'&lt;','>'=>'&gt;'))."</option>\n";
			unset($htmlOptions['empty']);
		}

		if(isset($htmlOptions['options']))
		{
			$options=$htmlOptions['options'];
			unset($htmlOptions['options']);
		}
		else
			$options=array();

		$key=isset($htmlOptions['key']) ? $htmlOptions['key'] : 'primaryKey';
		if(is_array($selection))
		{
			foreach($selection as $i=>$item)
			{
				if(is_object($item))
					$selection[$i]=$item->$key;
			}
		}
		elseif(is_object($selection))
			$selection=$selection->$key;

		foreach($listData as $key=>$value)
		{
			if(is_array($value))
			{
				$content.='<optgroup label="'.($raw?$key : self::encode($key))."\">\n";
				$dummy=array('options'=>$options);
				if(isset($htmlOptions['encode']))
					$dummy['encode']=$htmlOptions['encode'];
				$content.=self::listOptions($selection,$value,$dummy);
				$content.='</optgroup>'."\n";
			}
			else
			{
				$attributes=array('value'=>(string)$key,'encode'=>!$raw);
				if(!is_array($selection) && !strcmp($key,$selection) || is_array($selection) && in_array($key,$selection))
					$attributes['selected']='selected';
				if(isset($options[$key]))
					$attributes=array_merge($attributes,$options[$key]);
				$content.=self::tag('option',$attributes,$raw?(string)$value : self::encode((string)$value))."\n";
			}
		}

		unset($htmlOptions['key']);

		return $content;
	}

	/**
	 * Renders the HTML tag attributes.
	 * Since version 1.1.5, attributes whose value is null will not be rendered.
	 * Special attributes, such as 'checked', 'disabled', 'readonly', will be rendered
	 * properly based on their corresponding boolean value.
	 * @param array $htmlOptions attributes to be rendered
	 * @return string the rendering result
	 */
	public static function renderAttributes($htmlOptions)
	{
		if(isset($htmlOptions['name'], self::$errors[$htmlOptions['name']])){
			if(isset($htmlOptions['class'])){
				$htmlOptions['class'] = $htmlOptions['class'] . " " . self::$errorCss;
			}
			else{
				$htmlOptions['class'] = self::$errorCss;
			}
		}
		static $specialAttributes=array(
			'autofocus'=>1,
			'autoplay'=>1,
			'async'=>1,
			'checked'=>1,
			'controls'=>1,
			'declare'=>1,
			'default'=>1,
			'defer'=>1,
			'disabled'=>1,
			'formnovalidate'=>1,
			'hidden'=>1,
			'ismap'=>1,
			'loop'=>1,
			'multiple'=>1,
			'muted'=>1,
			'nohref'=>1,
			'noresize'=>1,
			'novalidate'=>1,
			'open'=>1,
			'readonly'=>1,
			'required'=>1,
			'reversed'=>1,
			'scoped'=>1,
			'seamless'=>1,
			'selected'=>1,
			'typemustmatch'=>1,
		);

		if($htmlOptions===array())
			return '';

		$html='';
		if(isset($htmlOptions['encode']))
		{
			$raw=!$htmlOptions['encode'];
			unset($htmlOptions['encode']);
		}
		else
			$raw=false;

		foreach($htmlOptions as $name=>$value)
		{
			if(isset($specialAttributes[$name]))
			{
				if($value===false && $name==='async') {
					$html .= ' ' . $name.'="false"';
				}
				elseif($value)
				{
					$html .= ' ' . $name;
					if(self::$renderSpecialAttributesValue)
						$html .= '="' . $name . '"';
				}
			}
			elseif($value!==null)
				$html .= ' ' . $name . '="' . ($raw ? $value : self::encode($value)) . '"';
		}

		return $html;
	}
}