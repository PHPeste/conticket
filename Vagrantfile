def which(cmd)
    exts = ENV['PATHEXT'] ? ENV['PATHEXT'].split(';') : ['']
    ENV['PATH'].split(File::PATH_SEPARATOR).each do |path|
        exts.each { |ext|
            exe = File.join(path, "#{cmd}#{ext}")
            return exe if File.executable? exe
        }
    end
    return nil
end

Vagrant.configure(2) do |config|
	config.vm.box = "ubuntu/trusty64"
	config.vm.network "forwarded_port", guest: 80, host: 8080

	config.vm.provider :virtualbox do |v|
		v.name = "phpeste-conticket"
		v.customize [
		    "modifyvm", :id,
		    "--name", "phpeste-conticket",
		    "--memory", 1024,
		    "--natdnshostresolver1", "on",
		    "--cpus", 1,
		]
	end

	if which('ansible-playbook')
		config.vm.provision "ansible" do |ansible|
		    ansible.playbook = "./ansible/playbook.yml"
		    ansible.inventory_path = "./ansible/inventories/dev"
		    ansible.limit = 'all'
		    ansible.sudo = true
		end
	else
		config.vm.provision :shell, path: "./ansible/windows.sh", args: ["phpeste-conticket"]
	end

	config.vm.network :private_network, ip: "192.168.33.99"

	config.vm.synced_folder "./../", "/vagrant", type: "rsync", rsync__exclude: ".git/"
end
