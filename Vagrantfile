# -*- mode: ruby -*-
# vi: set ft=ruby :

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = "ubuntu/trusty64"
  config.vm.network "forwarded_port", guest: 4000, host: 4000
  config.vm.hostname = "github-pages"
  config.vm.synced_folder ".", "/home/vagrant/blog"
  config.ssh.forward_agent = true
  config.vm.provision "shell", path: "./provisioner"
  config.vm.provision "shell", inline: "cd /home/vagrant/blog && bundle install", privileged: false
  config.vm.provision "shell", inline: "cd /home/vagrant/blog && bundle exec jekyll serve", run: "always", privileged: false
end
