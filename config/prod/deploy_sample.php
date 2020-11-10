<?php

declare(strict_types=1);

use EasyCorp\Bundle\EasyDeployBundle\Configuration\DefaultConfiguration;
use EasyCorp\Bundle\EasyDeployBundle\Deployer\DefaultDeployer;

/**
 * This is a sample class. To deploy, copy this file to deploy.php and fix the
 * settings corresponding to your server. The first setting to change is the
 * "server()" call. Don't forget to create a ".env" file in the "shared" directory
 * of the "deployDir()". Check out the commited ".env" file.
 */
return new class extends DefaultDeployer {
    public function configure(): DefaultConfiguration
    {
        return $this->getConfigBuilder()
            ->server('deploy-agent@myserver.net:22')
            ->useSshAgentForwarding(true)
            ->deployDir('/var/www/phpquiz.xyz')
            ->repositoryUrl('git@github.com:strangebuzz/phpquiz.git')
            ->repositoryBranch('master')
            ->keepReleases(3)
            ->remoteComposerBinaryPath('/usr/bin/composer')
            ->composerInstallFlags('--no-interaction --quiet --no-dev --optimize-autoloader')
            ->sharedFilesAndDirs(['.env'])
            ->fixPermissionsWithChown('www-data');
    }

    public function beforePublishing(): void
    {
        $this->runRemote('make load-fixtures');
        $this->runRemote('yarn install');
        $this->runRemote('make build');
        $this->runRemote('make fix-perms');
    }
};
