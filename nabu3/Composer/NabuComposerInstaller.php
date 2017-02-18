<?php

/*  Copyright 2009-2011 Rafael Gutierrez Martinez
 *  Copyright 2012-2013 Welma WEB MKT LABS, S.L.
 *  Copyright 2014-2016 Where Ideas Simply Come True, S.L.
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 */

namespace nabu3\Composer;

use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;

/**
 * Class to implement the Plugin Installer of Composer.
 * @author Rafael Gutierrez <rgutierrez@wiscot.com>
 * @since 3.0.0 Surface
 * @version 3.0.16 Surface
 * @package \providers\smarty
 */
class NabuComposerInstaller extends LibraryInstaller
{
    const SOURCE_PATH = 'src';
    const PUB_PATH = 'pub';
    const SDK_PATH = 'sdk';
    const PROVIDERS_PATH = 'providers';
    const RUNTIME_PATH = 'runtime';

    public function getInstallPath(PackageInterface $package)
    {
        $name = $package->getPrettyName();
        if (substr($name,0, 7) !== 'nabu-3/') {
            throw new \InvalidArgumentException(
                'Unable to install nabu-3 Package.'
            );
        }

        switch ($package->getType()) {
            case 'project':
                $path = self::SOURCE_PATH;
                break;
            case 'nabu-sdk':
                $path = self::SDK_PATH;
                break;
            case 'nabu-provider':
                $path = self::PUB_PATH . DIRECTORY_SEPARATOR . self::PROVIDERS_PATH . DIRECTORY_SEPARATOR . str_replace('-', DIRECTORY_SEPARATOR, substr($name, 16));
                break;
            case 'nabu-runtime':
                $path = self::PUB_PATH . DIRECTORY_SEPARATOR . self::RUNTIME_PATH . DIRECTORY_SEPARATOR . str_replace('-', DIRECTORY_SEPARATOR, substr($name, 15));
                break;
            default:
                throw new \InvalidArgumentException(
                    'Invalid package type "' . $package->getType() . '"'
                );
        }

        return $path;
    }

    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {
        return in_array($packageType, array('project', 'nabu-sdk', 'nabu-provider'));
    }
}
