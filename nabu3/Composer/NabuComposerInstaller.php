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
 * @version 3.0.0 Surface
 * @package \providers\smarty
 */
class NabuComposerInstaller extends LibraryInstaller
{
    public function getInstallPath(PackageInterface $package)
    {
        $name = $package->getPrettyName();
        if (substr($name,0, 7) !== 'nabu-3/') {
            throw new \InvalidArgumentException(
                'Unable to install nabu-3 Package.'
            );
        }

        error_log("Package type detected: " . $package->getType());
        switch ($package->getType()) {
            case 'project':
                $path = 'phputils' . DIRECTORY_SEPARATOR;
                break;
            case 'nabu-devel':
                $path = 'phputils' . DIRECTORY_SEPARATOR;
                break;
            case 'nabu-provider':
                $path = 'phputils' . DIRECTORY_SEPARATOR . 'providers' . DIRECTORY_SEPARATOR . substr($name, 7);
                break;
            default:
                throw new \InvalidArgumentException(
                    'Invalid package type "' . $package->getType() . '"'
                );
        }

        error_log("Path selected: $path");

        return $path;
    }

    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {
        return in_array($packageType, array('project', 'devel'));
    }
}
