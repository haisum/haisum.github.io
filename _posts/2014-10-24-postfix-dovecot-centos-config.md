---
layout: post
title: Config for mail server on Centos using Postfix and Dovecot
---

I have setup mail servers so many times, each time I forget the correct config. So here's a set of configs I just setup for a mail server on centos 6. It will act as future reference for me. I would be glad if it helps anyone else too.

Features
---------
- Sets up server on domain dev.pk
- Rejects all outgoing or incoming to domains other than $mydestination
- Check smtp_recipient_restrictions in postfix/main.cf
- No smtp authentication for local network 192.168.1.0/24
- IMAP on dovecot authenticated by usernames and passwords of linux system users (create them using `useradd -m`)
- Mail saved in ~/mail
- Aliases set via regex `/test([0-9]*).(.*)@dev.pk/ $2@dev.pk in /etc/postfix/virtual_aliases
- Run `postmap /etc/postfix/virtual_aliases`

Postfix
----------

Here's what's changed from default in /etc/postfix/main.cf:

{% hightlight python %}
inet_interfaces = all
inet_protocols = all
mydestination = $myhostname, localhost.$mydomain, localhost, dev.pk
unknown_local_recipient_reject_code = 550
mynetworks_style = subnetmynetworks = 192.168.1.0/24, 192.168.2.0/24
relay_domains = $mydestination
smtpd_sasl_type = dovecot
smtpd_sasl_path = private/auth
smtpd_sasl_local_domain = example.tst
smtpd_sasl_security_options = noanonymous
broken_sasl_auth_clients = yes
smtpd_sasl_auth_enable = yes
smtpd_recipient_restrictions = reject_unauth_destination,  reject_unauth_pipelining,   reject_non_fqdn_recipient,   reject_unknown_recipient_domain, permit_mynetworks
virtual_alias_maps = regexp:/etc/postfix/virtual_alias
{% endhighlight %}

Alias file (/etc/postfix/virtual_alias):

{% hightlight python %}
/^test([0-9]*)\.(.*)@dev.pk/ $2@dev.pk
{% endhighlight %}


Do `postmap /etc/postfix/virtual_alias` and `service postfix restart` after changing

Dovecot
-----

/etc/dovecot/dovecot.conf:

{% hightlight python %}
protocols = imap pop3 
login_trusted_networks = 192.168.1.0/24
!include conf.d/*.conf
auth_debug_passwords=yes
auth_username_format = %Ln
mail_location = mbox:~/mail:INBOX=/var/spool/mail/%u
mail_access_groups = mail
{% endhighlight %}
Be sure to check mail_location and verify if your inbox is at /var/spool/mail/username

/etc/dovecot/conf.d/10-master.conf:

{% hightlight python %}
service imap-login {
  inet_listener imap {
    port = 143
    address = *
  }
  inet_listener imaps {
    port = 993
    ssl = yes
    address = *
  }
}

service pop3-login {
  inet_listener pop3 {
    port = 110
    address = *
  }
  inet_listener pop3s {
    port = 995
    ssl = yes
    address = *
  }
}

service lmtp {
  unix_listener lmtp {
    #mode = 0666
  }
}

service imap {
}

service pop3 {
}

service auth {
  unix_listener auth-userdb {
  }

  # Postfix smtp-auth
  unix_listener /var/spool/postfix/private/auth {
    mode = 0666
    user = postfix
    group = postfix
  }

  unix_listener auth-master {
    mode = 0666
  }

}

service auth-worker {
}

service dict {
  unix_listener dict {
  }
}

{% endhighlight %}

Source files:

	- [/etc/postfix/main.cf](/public/downloads/postfix/main.cf)
	- [/etc/postfix/virtual_alias](/public/downloads/postfix/virtual_alias)
	- [/etc/dovecot/dovecot.conf](/public/downloads/dovecot/dovecot.conf)
	- [/etc/dovecot/conf.d/10-master.conf](/public/downloads/dovecot/conf.d/10-master.conf)