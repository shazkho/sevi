<?php
/**
 * SEVI: Sistema para la evaluación integral
 *
 * SEVI es una plataforma construida para facilitar la evaluación,
 * co-evaluación, auto-evaluación y gestión básica de asignaturas
 * que contemplan proyectos grupales semestrales.
 *
 * PHP Version 5.4
 *
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @copyright   2015 Mahou Ingeniería
 * @license     http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @version     0.0.1-prototype
 */

if (!defined('BASEPATH')) exit('No se permite husmear aquí');

?>
<div class="header-main">
    <div class="logo-box">
        <img src="assets/images/{LOGO}" class="logo-img" alt="SEVI" title="SEVI">
    </div>
    <div class="user-box">
        <div class="user-name">
            <span>{USERNAME}</span>
        </div>
        <div class="user-controls">
            <ul>
                <li><a href="#">Ver Perfil</a></li>
                <li><a href="#">Salir</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="header-separator"></div>