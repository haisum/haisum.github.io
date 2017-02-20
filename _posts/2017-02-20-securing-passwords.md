---
layout: post
title: Let's talk about passwords
---

I was frustrated at setting up password for my bank's internet banking portal. It's frustrating to come up with passwords that follow annoying rules of having particular set of combinations to get a strong password. It's even more difficult to remember such passwords. It doesn't even solve problem of making passwords strong. P@ssword1 is considered strong by such rules but it takes seconds to get cracked with good password dictionary. Such composition based rules for password strength have been discouraged in [latest IANS password guidelines](https://www.iansresearch.com/insights/blog/blog-insights/2016/08/24/ians-faculty-break-down-nist-s-proposed-new-password-guidelines).

XKCD summarizes this situation beautifully in following comic:

![Password Strength](/public/images/password_strength.png)

*Source :* [Password Strength](https://xkcd.com/936/)

Thankfully we have much better alternates to composite rules for making sure passwords are strong. Most recommended way is to use entropy based algorithms to check password strength. Dropbox's [dropbox/zxcvbn]([https://github.com/dropbox/zxcvbn]) project is one of most promising projects to make passwords strong without annoying your users.

 Entropy based password checkers like zxcvbn recognize and weigh common passwords, common names, popular words, television shows, movies and other common patterns like dates, repeats (aaa), sequences (abcd), keyboard patterns (qwertyuiop) and other sensible information. Such checks keep passwords secure, memorizable and your users sane.

Another problem with passwords is remembering them. No matter how strong password you have, if you use it everywhere, hacking into one of those sites compromises every other site you have used it on. So you need to practice different passwords for different sites. Remembering strong and different passwords for every site we visit is almost impossible. That's where password managers come in.

If you're not technical and want a simple solution you can opt for [Lastpass](http://lastpass.com/). I have been using it for password management since forever and it keeps me quite happy. You can add two factor authentication to be extra safe on lastpass. Password manager can generate, save and manage your passwords for all sites. You just need to remember your master password then.

If you're advance user and are comfortable with terminal, I recommend using [pass](https://www.passwordstore.org/). It's GPG based text storage for secret data. You can manage a git repo with all your passwords encrypted via your GPG key. There are many GUI tools, browser extensions and smartphone apps available free of cost for pass.

That's all on passwords for now. Better safe than sorry. Take care of your online privacy and make passwords great again.