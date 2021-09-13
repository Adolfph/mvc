<?php

namespace Models;

/**
 * Description of menumodel
 * @date 11 sep. 2021
 * @time 16:37:48
 * @author Adolfo Jiménez <isc.adolfojimenez@gmail.com>
 */
use Core\Model;
use Core\IModel;
use PDO;

class MenuModel extends Model implements IModel
{
    private $id;
    private $nombre;
    private $descripcion;
    private $id_menu_padre;
    private $nombre_menu_padre;
    private $fecha_de_registro;
    private $fecha_de_edicion;
    private $childs;

    public function __construct()
    {
        parent::__construct();
    }

    public function get($id)
    {
        try {
            $query = $this->prepare('SELECT id, nombre, descripcion, id_menu_padre, fecha_de_registro, fecha_de_edicion FROM app_menus WHERE id = :id');
            $query->execute(['id' => $id]);
            $menu = $query->fetch(PDO::FETCH_ASSOC);
            if(empty($menu)){
                return false;
            }
            $this->from($menu);
            return $this;
        } catch (PDOException $e) {
            error_log("MenuModel::get->PDOException $e");
            return false;
        }
    }

    public function getAll()
    {
        $items = [];

        try {
            $query = $this->query('SELECT id, nombre, descripcion, id_menu_padre, fecha_de_registro, fecha_de_edicion FROM app_menus');

            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $item = new MenuModel();
                if(!empty($row['id_menu_padre'])){
                    $menuPadre = new MenuModel();
                    $menuPadre->setId($row['id_menu_padre']);
                    $menuPadre->get($row['id_menu_padre']);
                    $row['nombre_menu_padre'] = $menuPadre->nombre;
                }
                $item->from($row);
                array_push($items, $item);
            }
            return $items;
        } catch (PDOException $e) {
            error_log("MenuModel::getAll-> PDOException $e");
        }
    }

    public function save()
    {
        try {
            $query = $this->prepare('INSERT INTO app_menus (nombre, descripcion, id_menu_padre, fecha_de_registro) VALUES(:nombre, :descripcion, :id_menu_padre, NOW())');

            $query->execute([
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion,
                'id_menu_padre' => $this->id_menu_padre
            ]);

            if ($query->rowCount()) {
                return true;
            }

            return false;
        } catch (PDOException $e) {
            error_log("MenuModel::save->PDOException $e");
            return false;
        }
    }

    public function update()
    {
        try {
            $query = $this->prepare('UPDATE app_menus SET nombre = :nombre, descripcion = :descripcion, id_menu_padre = :id_menu_padre WHERE id = :id');
            $query->execute([
                'id' => $this->id,
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion,
                'id_menu_padre' => $this->id_menu_padre
            ]);

            return true;
            
        } catch (PDOException $e) {
            echo $e;
            return false;
        }
    }

    public function delete($id)
    {
        try{
            $query = $this->prepare('DELETE FROM app_menus WHERE id = :id');
            error_log ($id);
            $query->execute(['id' => $id]);
            return true;
        }catch(PDOException $e){
            error_log("MenuModel:::delete->PDOException ".$e);
            return false;
        }
    }

    public function from($array)
    {
        $this->id = $array['id'];
        $this->nombre = $array['nombre'];
        $this->descripcion = $array['descripcion'];
        $this->id_menu_padre = $array['id_menu_padre'];
        if(!empty($array['nombre_menu_padre'])){
            $this->nombre_menu_padre = $array['nombre_menu_padre'];
        }
        $this->fecha_de_registro = $array['fecha_de_registro'];
        $this->fecha_de_edicion = $array['fecha_de_edicion'];
    }

    public function fromArray($object)
    {
        $array['id'] = $object->id;
        $array['nombre'] = $object->nombre;
        $array['descripcion'] = $object->descripcion;
        $array['id_menu_padre'] = $object->id_menu_padre;
        if(!empty($object->nombre_menu_padre)){
            $array['id_menu_padre'] = $object->nombre_menu_padre;
        }
        $array['fecha_de_registro'] = $object->fecha_de_registro;
        $array['fecha_de_edicion'] = $object->fecha_de_edicion;
        $arrChilds = null;
        
        if(!empty($object->getChilds())){
            foreach ($object->getChilds() as $child) {
                $arrChilds[] = $child->fromArray($child);
            }
        }
        $array['childs'] = $arrChilds;

        return $array;
    }

    public function obtenerMenusHijos($id_menu_padre)
    {
        $hijos = [];
        $query = $this->prepare("SELECT id, nombre, descripcion, id_menu_padre, fecha_de_registro, fecha_de_edicion FROM app_menus WHERE id_menu_padre = :id_menu_padre");
        $query->execute(['id_menu_padre' => $id_menu_padre]);

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $hijo = new MenuModel();
            $hijo->from($row);
            array_push($hijos, $hijo);
        }
        
        return $hijos;
    }

    public function getOrderedMenus()
    {
        $items = [];
        $query = $this->prepare("SELECT id, nombre, descripcion, id_menu_padre, fecha_de_registro, fecha_de_edicion FROM app_menus WHERE id_menu_padre IS NULL");
        $query->execute();

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $item = new MenuModel();
            $item->from($row);
            $item->setChilds($this->obtenerMenusHijos($item->id));
            array_push($items, $item);
        }
        return $items;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function getId_menu_padre()
    {
        return $this->id_menu_padre;
    }

    public function getNombre_menu_padre()
    {
        return $this->nombre_menu_padre;
    }

    public function getFecha_de_registro()
    {
        return $this->fecha_de_registro;
    }

    public function getFecha_de_edicion()
    {
        return $this->fecha_de_registro;
    }

    public function getChilds()
    {
        return $this->childs;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        return $this;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
        return $this;
    }

    public function setNombre_menu_padre($nombre_menu_padre)
    {
        $this->nombre_menu_padre = $nombre_menu_padre;
        return $this;
    }

    public function setId_menu_padre($id_menu_padre)
    {
        $this->id_menu_padre = $id_menu_padre;
        return $this;
    }

    public function setFecha_de_registro($fecha_de_registro)
    {
        $this->fecha_de_registro = $fecha_de_registro;
        return $this;
    }

    public function setChilds($childs)
    {
        $this->childs = $childs;
        return $this;
    }
}
