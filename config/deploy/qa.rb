role :app, %w{dosomething@gladiator-qa}

server 'gladiator-qa', user: 'dosomething', roles: %w{app}, master: true

desc 'Run PHPUnit tests'
task :gulp do
  on roles(:all) do
    within "#{release_path}" do
      execute "vendor/bin/phpunit"
    end
  end
end
