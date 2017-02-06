namespace :laravel do
  desc 'Run PHPUnit tests'
  task :phpunit do
    on roles(:all) do
      within "#{release_path}" do
        execute "vendor/bin/phpunit"
      end
    end
  end

  desc 'Run Gulp build'
  task :gulp do
    on roles(:all) do
      within "#{release_path}" do
        execute "gulp"
      end
    end
  end

  desc 'Run Artisan tasks'
  task :artisan_tasks do
    on roles(:all) do
      within "#{release_path}" do
        execute :php, "artisan migrate --force && php artisan cache:clear"
      end
    end
  end
end

namespace :deploy do
 if ENV["TIER"] == "qa"
   after :updated, "laravel:phpunit"
 end
 after :updated, "laravel:gulp"
 after :updated, "laravel:artisan_tasks"
end