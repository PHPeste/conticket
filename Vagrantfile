# -*- mode: ruby -*-
# vi: set ft=ruby :

VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

    config.vm.box = "ubuntu/trusty64"
    config.vm.network "private_network", ip: "192.168.33.99"
    config.vm.provision "ansible" do |ansible|
        ansible.playbook = "ansible/playbook.yml"
        ansible.sudo = true
        ansible.extra_vars = {
            ansible_ssh_user: 'vagrant',
            httpd_run_user: 'vagrant',
            httpd_run_group: 'vagrant'
        }
    end

end
