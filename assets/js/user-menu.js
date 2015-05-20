/*
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

// VÍNCULOS DEL MENU DE USUARIO

var link = [];

link[0]  = "#"; // Ingeniería de software
link[1]  = "#"; // inicio
link[2]  = "#"; // co-evaluación
link[3]  = "#"; // calificaciones
link[4]  = "#"; // entregas
link[5]  = "#"; // contenidos
link[6]  = "#"; // archivos
link[7]  = "#"; // grupo
link[8]  = "#"; // perfil
link[9]  = "#"; // contraseña
link[10] = "#"; // alertas

// EVENTOS JQUERY

$( document ).ready(function () {

    $('.menu-element').click(function () {
        var id = $( this).attr('id');
        window.location = link[id];
    });

});































