---
layout: post
title: Yii Html class for use in non Yii projects
---

Forms are essential for any web development project. Tasks we do in building and populating forms, such as checking value in `$_POST`, `$_GET` and populating that, populating drop downs with data from database and pre selecting data, are redundant. While using [Yii framework](http://www.yiiframework.com) I loved their CHtml class. It had all the effort done for you, you only had to use it properly and it would do most of redundant tasks for you.

Recently I was working on a flat code project and had to perform all these tasks with flat code, so instead of continuing to write redundant code I refactored [Yii's CHtml class](http://www.yiiframework.com/doc/api/1.1/CHtml) to be used in general non Yii projects. So following modifications were done to make it compatible with Non Yii projects:

- No support for Active Controls
- Error methods don't accept model(s) as argument instead they accept key as attribute
- If an input control's name is set in `$_REQUEST` it is picked as value and supplied value is ignored
- No support for clientChange option in htmlOptions
- No javascript validation support
- Name was changed to Html

I encourage you to use it, it will reduce your development time and will produce good consistent code.


Usage
--------

**Note:** *PHP >= 5.4 required*

Here's simple usage example:

{% highlight php %}
<?php
require_once "Html.class.php";
Html::$errors = [];
if(count($_POST) > 1){
	if(trim($_POST['email']) == ""){
		Html::$errors['email'] = "Email can't be blank";
	}
	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
		Html::$errors['email'] = "Invalid Email";
	}
}

echo Html::beginForm();
//renders label with text and for="email" tag
echo Html::label("Email Address:", "email");
//renders <input type="text" value="" name="email" id="email"/> with value automatically set after post
//also gives class="error" if Html::$errors['email'] is not empty
echo Html::textField("email");
//shows error if Html::$errors['email'] is not empty
echo Html::error("email");
echo Html::submit("Submit");
?>
{% endhighlight %}

Read source code comments for understanding further details.

Source Code
-------
- [Modified Non Yii Html class](https://gist.github.com/haisum/4e47cd8e23a8227814b36fbf362786f5)
- [Yii CHtml class](https://raw.githubusercontent.com/yiisoft/yii/master/framework/web/helpers/CHtml.php)
- [Yii CHtml docs](http://www.yiiframework.com/doc/api/1.1/CHtml)
