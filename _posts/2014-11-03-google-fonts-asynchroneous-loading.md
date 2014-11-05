---
layout: post
title: Load Google fonts asynchroneously so they don't make your site unresponsive
---

Google fonts are very popular among designers these days, they provide a way to use fancy fonts all across the web without worrying about their availability on client's computer. But with one problem that they solve, they bring one problem of their own: Synchroneous loading of fonts from Google servers and therefore pausing page render until they are downloaded. Resulting in a pause on every web page where google fonts are used.

![css selection google fonts](/public/images/google-fonts-select-css.png)

![javascript asynchroneous selection google fonts](/public/images/google-fonts-select-async-javascript.png)

{% highlight diff %}
-  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=PT+Serif:400,400italic,700%7CPT+Sans:400">
-
+  <!-- Load Google fonts asynchroneously -->
+  <script type="text/javascript">
+  WebFontConfig = {
+    google: { families: [ 'PT+Serif:400,700,400italic:latin', 'PT+Sans:400:latin' ] }
+  };
+  (function() {
+    var wf = document.createElement('script');
+    wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
+      '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
+    wf.type = 'text/javascript';
+    wf.async = 'true';
+    var s = document.getElementsByTagName('script')[0];
+    s.parentNode.insertBefore(wf, s);
+  })(); </script>
{% endhighlight %}

*still in drafts will update with content soon*