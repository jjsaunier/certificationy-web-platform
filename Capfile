set :deploy_config_path, "deployment/deploy.rb"
set :stage_config_path, "deployment/stages/"

require 'capistrano/setup'
require 'capistrano/deploy'
require 'capistrano/symfony'
require 'capistrano/composer'
require 'capistrano/grunt'
require 'capistrano/bower'
require 'capistrano/npm'
require 'capistrano'

Dir.glob('deployment/tasks/*.cap').each { |r| import r }