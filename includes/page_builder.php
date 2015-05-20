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


/**
 * Class Page_builder
 *
 * Construye una página de acuerdo a la información enviada.
 *
 * @since   0.0.1-prototype
 * @author  Anníbal Llanos Prado
 */
class Page_builder
{

    /* - - VARIABLES DE INSTANCIA - - - - - - - - - - - - - - - - - - - - - - - - - - - - */

    /**
     * @var string La ruta base del archivo 'index.php' en la raíz del sitio.
     */
    protected $basepath;

    /**
     * @var string La ruta hacia la carpeta "templates"
     */
    protected $templates_path;


    /* - - CONSTRUCTOR - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */

    /**
     * Constructor
     *
     * @param string $basepath La ruta base del archivo 'index.php' en la raíz del sitio.
     *
     * @since 0.0.1-prototype
     */
    public function __construct($basepath)
    {
        $this->basepath = $basepath;
        $this->templates_path = $basepath.DS.'includes'.DS.'templates'.DS;
    }


    /* - - CREADORES DE PÁGINA - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */

    /**
     * Creador principal de páginas. Delega la carga para facilitar el uso desde el index.
     *
     * @param string $page La página solicitada
     * @param string $layout El layout que se le asignará a dicha página
     *
     * @return string El HTML de la página solicitada.
     *
     * @since 0.0.1-prototype
     * @access public
     */
    public function build($page, $path, $layout='base')
    {
        switch ($layout) {
            case 'base':
                return $this->build_base($page, $path);
            default:
                return 'El layout solicitado no existe.';
        }
    }


    /**
     * Creador de una vista básica. Es la vista más común en SEVI. El template que la define requiere
     * los siguientes elementos definidos dentro del parámetro "strings":
     *
     *  - 'title':      El título de la página (el que es definido en el "head")
     *  - 'resources' : El HTML de los recursos a incorporar
     *  - 'header':     El HTML del header del sitio (se construye a partir del template)
     *  - 'body':       El HTML del cuerpo del sitio (se construye a partir del template)
     *  - 'footer':     El HTML del pie de página del sitio (se construye a partir del template)
     *
     * @param string $page La página solicitada
     *
     * @return string El HTML de la página solicitada.
     *
     * @since 0.0.1-prototype
     * @access public
     */
    public function build_base($page, $path)
    {
        $strings = array(
            'title' => 'SEVI: Página de ejemplo',
            'resources' => $this->resources(
                array(
                    'pure-min' => false,
                    'global' => false,
                    'header' => false,
                    'user-menu' => false,
                    'content' => false
                ),
                array(
                    'jquery-1.11.3.min' => false,
                    'user-menu' => false
                )
            ),
            'header' => $this->build_header(),
            'user-menu' => $this->build_user_menu(),
            'body' => $this->template($page, array(), $path),
            'footer' => $this->template('footer', array())
        );
        return $this->template('base', $strings);
    }


    /**
     * Creador del header principal del sitio. El template que la define requiere los siguientes
     * elementos definidos dentro del parámetro "strings":
     *
     *  - 'logo':     Nombre del archivo a ser usado como logo (debe estar en 'assets/images')
     *  - 'username': El nombre completo del usuario conectado
     *
     * @return string el HTML del header
     *
     * @since 0.0.1-prototype
     * @access protected
     */
    protected function build_header()
    {
        $strings = array(
            'logo' => 'sevi-proto2.png',
            'username' => 'Aníbal Esteban Llanos Prado'
        );
        return $this->template('header', $strings);
    }


    protected function build_user_menu()
    {
        return $this->template('user-menu', array());
    }


    /* - - FUNCIONES DE TEMPLATE - - - - - - - - - - - - - - - - - - - - - - - - - - - - */

    /**
     * Obtiene el template solicitado excluyendo los bloques PHP que pueda tener definidos.
     * Si el template solicitado no es encontrado termina la ejecución con error.
     *
     * @param string $template El nombre del template a ser buscado.
     * @param string $path Carpeta en la que se encuentra el template (se omite si está en la raíz).
     *
     * @return string El template en bruto (con los tokens sin reemplazar)
     *
     * @since 0.0.1-prototype
     * @access protected
     */
    protected function get_template($template, $path='')
    {
        if ($path) $path = $path.DS;
        $file = @file_get_contents($this->templates_path.$path.$template.'.php');
        if ($file === false) $file = file_get_contents($this->templates_path.'errors'.DS.'404.php');

        $re = "/<\\?php([\\s\\S]*)\\?>/iU";
        return preg_replace($re, '', $file);
    }


    /**
     * Gestiona el proceso de obtención y reemplazo de tokens para un template en particular.
     * Primero, obtiene el template utilizando la función 'get_template' y luego reemplaza
     * los elementos definidos en el arreglo "strings" entregado como parámetro.
     *
     * El arreglo "strings" es un arreglo asociativo cuyos elementos se utilizarán para
     * evaluar el template. En los templates, los tokens a reemplazar tienen la forma {TOKEN}
     * y para ser reemplazados se debe definir un índice "token" (sin las llaves) con el
     * valor que se desea reemplazar. Ejemplo:
     *
     *     Template:  'El {ELEMENTO} es de color {COLOR}'
     *     Strings:   array( 'elemento' => 'cielo', 'color' => 'azul' )
     *     Resultado: 'El cielo es de color azul'
     *
     * Si en el arreglo 'strings' se define un token que no se encuentra en el template no
     * ocurrirá nada (dado el funcionamiento de la función 'str_replace' de PHP. Adicionalmente,
     * si no se define un token que se encuentra en el template, se retornará en su forma
     * original. Ejemplo:
     *
     *     Template:  'El {ELEMENTO} es de color {COLOR}'
     *     Strings:   array( 'elemento' => 'cielo', 'sabor' => 'amargo' )
     *     Resultado: 'El cielo es de color {COLOR}'
     *
     * @param string $template El nombre del template a ser buscado.
     * @param array $strings El arreglo con los reemplazos para el template
     *
     * @return string El HTML del template reemplazado con los strings entregados
     */
    protected function template($template, $strings, $path='')
    {
        $template_html = $this->get_template($template, $path);
        foreach ($strings as $name => $value) {
            $template_html = str_replace('{'.strtoupper($name).'}', $value, $template_html);
        }
        return $template_html;
    }


    /**
     * Crea el HTML para la importación de recursos CSS y JS. La información de los recursos es entregada
     * en forma de arreglos indexados y de 1 dimensión. En el arreglo, el índice es el nombre del
     * archivo a incluir (sensible a mayúsculas y minúsculas) sin la extensión, y el valor es la ruta
     * al archivo (si se define FALSE en lugar de la ruta, se utilizará la ruta por defecto en la carpeta
     * 'assets', relativa a la raíz del sitio. Ejemplo de arreglo:
     *
     *     $css = array(
     *         'estilo1' => 'ruta\personalizada\',   // Busca el archivo {RAÍZ]\ruta\personalizada\estilo1.css
     *         'estilo2' => FALSE                    // Busca el archivo {RAÍZ}\assets\css\estilo2.css
     *     );
     *
     * IMPORTANTE: Los archivos son incluidos en orden y en CSS las clases definidas se sobre-escriben si se
     * re-define una previamente definida, por lo que si se desea que algún recurso sea procesado con mayor
     * prioridad (que no sea sobre-escrito), se deberá definir al final.
     *
     *
     * @param array $css El arreglo con las hojas de estilo CSS
     * @param array $js El arreglo con los scrips JavaScript
     *
     * @return string El HTML para la inclusión de los recursos solicitados
     *
     * @since 0.0.1-prototype
     * @access protected
     */
    protected function resources($css, $js=array())
    {
        $resources = array();
        foreach ($css as $res => $path) {
            if ($path === false) $path = 'assets'.DS.'css'.DS;
            array_push($resources, '<link rel="stylesheet" type="text/css" href="'.$path.$res.'.css">
            ');
        }
        foreach ($js as $res => $path) {
            if ($path === false) $path ='assets'.DS.'js'.DS;
            array_push($resources, '<script type="text/javascript" src="'.$path.$res.'.js"></script>
            ');
        }
        return join('', $resources);
    }

}






























