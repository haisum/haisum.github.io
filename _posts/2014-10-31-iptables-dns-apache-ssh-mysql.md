---
layout: post
title: iptables with postfix, dovecot, dns server, apache, ssh and mysql
---

I had to go through a lot of pain, to get it right. Dumping my iptables config here so it acts like future reference for me and help anyone else trying hard to get it right.

Will explain what it does in future if I get some free time.

#### iptables-save

```
*filter
:INPUT DROP [651:121730]
:FORWARD DROP [0:0]
:OUTPUT DROP [781:49805]
:LOGGING - [0:0]
-A INPUT -i lo -j ACCEPT
-A INPUT -m state --state RELATED,ESTABLISHED -j ACCEPT
-A INPUT -s 192.168.1.0/24 -d 192.168.1.254/32 -p icmp -m icmp --icmp-type 0 -m state --state NEW,RELATED,ESTABLISHED -j ACCEPT
-A INPUT -s 192.168.1.0/24 -d 192.168.1.254/32 -p icmp -m icmp --icmp-type 8 -m state --state NEW,RELATED,ESTABLISHED -j ACCEPT
-A INPUT -s 192.168.1.0/24 -d 192.168.1.254/32 -p tcp -m tcp --dport 22 -j ACCEPT
-A INPUT -p tcp -m tcp --sport 22 -m state --state ESTABLISHED -j ACCEPT
-A INPUT -i eth0 -p tcp -m tcp --sport 443 -m state --state ESTABLISHED -j ACCEPT
-A INPUT -s 192.168.1.0/24 -p tcp -m tcp --dport 80 -m state --state NEW,ESTABLISHED -j ACCEPT
-A INPUT -s 192.168.1.0/24 -p tcp -m tcp --dport 3306 -m state --state NEW,ESTABLISHED -j ACCEPT
-A INPUT -s 192.168.1.0/24 -p tcp -m tcp --dport 25 -m state --state NEW,ESTABLISHED -j ACCEPT
-A INPUT -s 192.168.1.0/24 -p tcp -m tcp --dport 143 -m state --state NEW,ESTABLISHED -j ACCEPT
-A INPUT -s 192.168.1.0/24 -p tcp -m tcp --dport 110 -m state --state NEW,ESTABLISHED -j ACCEPT
-A INPUT -s 192.168.1.0/24 -p tcp -m tcp --dport 993 -m state --state NEW,ESTABLISHED -j ACCEPT
-A INPUT -s 192.168.1.0/24 -p tcp -m tcp --dport 995 -m state --state NEW,ESTABLISHED -j ACCEPT
-A INPUT -p icmp -m icmp --icmp-type 0 -j ACCEPT
-A INPUT -p tcp -m tcp --sport 53 -j ACCEPT
-A INPUT -p udp -m udp --sport 53 -j ACCEPT
-A INPUT -s 192.168.1.0/24 -p udp -m udp --dport 53 -j ACCEPT
-A INPUT -s 192.168.1.0/24 -p tcp -m tcp --dport 53 -j ACCEPT
-A INPUT -s 192.168.1.0/24 -p udp -m udp --dport 137 -j ACCEPT
-A INPUT -s 192.168.1.0/24 -p udp -m udp --dport 138 -j ACCEPT
-A INPUT -s 192.168.1.0/24 -p tcp -m tcp --dport 139 -j ACCEPT
-A INPUT -s 192.168.1.0/24 -p tcp -m tcp --dport 445 -j ACCEPT
-A INPUT -j LOG --log-prefix "INPUT:DROP:"
-A INPUT -p tcp -m tcp --sport 22 -j ACCEPT
-A INPUT -p tcp -m tcp --sport 2200 -j ACCEPT
-A OUTPUT -d 8.8.8.8/32 -p icmp -m icmp --icmp-type 8 -m state --state NEW,RELATED,ESTABLISHED -j ACCEPT
-A OUTPUT -d 8.8.4.4/32 -p icmp -m icmp --icmp-type 8 -m state --state NEW,RELATED,ESTABLISHED -j ACCEPT
-A OUTPUT -s 192.168.1.254/32 -d 192.168.1.0/24 -p icmp -m icmp --icmp-type 0 -m state --state NEW,RELATED,ESTABLISHED -j ACCEPT
-A OUTPUT -o lo -j ACCEPT 
-A OUTPUT -p tcp -m tcp --dport 22 -j ACCEPT
-A OUTPUT -p tcp -m tcp --dport 2200 -j ACCEPT
-A OUTPUT -s 192.168.1.254/32 -d 67.222.132.30/32 -p icmp -m icmp --icmp-type 8 -j ACCEPT
-A OUTPUT -s 192.168.1.254/32 -d 67.222.151.62/32 -p icmp -m icmp --icmp-type 8 -j ACCEPT
-A OUTPUT -p tcp -m tcp --sport 22 -m state --state ESTABLISHED -j ACCEPT 
-A OUTPUT -p tcp -m tcp --dport 443 -m state --state NEW,ESTABLISHED -j ACCEPT 
-A OUTPUT -p tcp -m tcp --sport 80 -m state --state ESTABLISHED -j ACCEPT 
-A OUTPUT -p tcp -m tcp --sport 3306 -m state --state ESTABLISHED -j ACCEPT 
-A OUTPUT -d 192.168.1.0/24 -p tcp -m tcp --sport 25 -m state --state NEW,ESTABLISHED -j ACCEPT
-A OUTPUT -d 192.168.1.0/24 -p tcp -m tcp --sport 143 -m state --state NEW,ESTABLISHED -j ACCEPT
-A OUTPUT -d 192.168.1.0/24 -p tcp -m tcp --sport 110 -m state --state NEW,ESTABLISHED -j ACCEPT 
-A OUTPUT -d 192.168.1.0/24 -p tcp -m tcp --sport 993 -m state --state NEW,ESTABLISHED -j ACCEPT 
-A OUTPUT -d 192.168.1.0/24 -p tcp -m tcp --sport 995 -m state --state NEW,ESTABLISHED -j ACCEPT 
-A OUTPUT -p icmp -m icmp --icmp-type 8 -j ACCEPT 
-A OUTPUT -p udp -m udp --sport 53 -j ACCEPT  
-A OUTPUT -p tcp -m tcp --sport 53 -j ACCEPT 
-A OUTPUT -s 192.168.1.0/24 -p udp -m udp --dport 53 -j ACCEPT
-A OUTPUT -s 192.168.1.0/24 -p tcp -m tcp --dport 53 -j ACCEPT
-A OUTPUT -p udp -m udp --sport 137 -j ACCEPT 
-A OUTPUT -p udp -m udp --sport 138 -j ACCEPT 
-A OUTPUT -p tcp -m tcp --sport 139 -j ACCEPT 
-A OUTPUT -p tcp -m tcp --sport 445 -j ACCEPT 
-A OUTPUT -j LOG --log-prefix "OUTPUT:DROP:" 
COMMIT 
```
#### Useful references

- [www.thegeekstuff.com/scripts/iptables-rules](http://www.thegeekstuff.com/scripts/iptables-rules)
- [wiki.centos.org/HowTos/Network/IPTables](http://wiki.centos.org/HowTos/Network/IPTables)