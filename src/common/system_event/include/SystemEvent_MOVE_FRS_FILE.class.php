<?php
/**
 * Copyright (c) Enalean, 2014. All rights reserved
 *
 * This file is a part of Tuleap.
 *
 * Tuleap is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * Tuleap is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Tuleap. If not, see <http://www.gnu.org/licenses/
 */

/**
 * Change User name
 *
 */
class SystemEvent_MOVE_FRS_FILE extends SystemEvent {

    const NAME          = 'MOVE_FRS_FILE';

    /**
     * Set multiple logs
     *
     * @param String $log Log string
     *
     * @return void
     */
    public function setLog($log) {
        if (!isset($this->log) || $this->log == '') {
            $this->log = $log;
        } else {
            $this->log .= PHP_EOL.$log;
        }
    }

    /**
     * Verbalize the parameters so they are readable and much user friendly in
     * notifications
     *
     * @param bool $with_link true if you want links to entities. The returned
     * string will be html instead of plain/text
     *
     * @return string
     */
    public function verbalizeParameters($with_link) {
        $txt = '';
        list($project_path, $file_id, $old_path) = $this->getParametersAsArray();
        $txt .= 'project_path: '. $project_path.' -file ID: '.$file_id.' -old file path: '.$old_path;
        return $txt;
    }

    /**
     * Process stored event
     *
     * @return Boolean
     */
    public function process() {
        list($project_path, $file_id, $old_path) = $this->getParametersAsArray();

        $file_factory = new FRSFileFactory();
        $file         = $file_factory->getFRSFileFromDb($file_id);

        if (! $file) {
            $this->error('File does not exist with ID ' . $file_id);
            return false;
        }

        $file_path = $file->getFilePath();
        $this->createNecessaryFolders($project_path, $file_path);

        if (file_exists($project_path . $old_path) && ! file_exists($project_path . $file_path)) {
            if (rename($project_path . $old_path, $project_path . $file_path)) {
                $this->done();
                return true;
            }
        }

        $this->error('Unable to move file: ' . $file_id . ' from: ' . $project_path.$old_path . ' to ' . $project_path . $file_path);
        return false;
    }

    private function createNecessaryFolders($project_path, $file_path) {
        $path_parts = explode('/', $file_path);

        if (count($path_parts) != 2) {
            $this->error('Bad file path: ' . $file_path);
            return;
        }

        if (! is_dir($project_path .$path_parts[0])) {
            mkdir($project_path .$path_parts[0]);
        }
    }
}
?>
