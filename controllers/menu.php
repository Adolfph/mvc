<?php

namespace Controllers;

/**
 * Description of menu
 * @date 11 sep. 2021
 * @time 16:34:20
 * @author Adolfo Jiménez <isc.adolfojimenez@gmail.com>
 */
use Core\Controller;
use Models\MenuModel;

class Menu extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function render()
    {
        $menus        = [];
        $menu         = new MenuModel();
        $menus        = $menu->getAll();
        $menusOrdered = $menu->getOrderedMenus();
        $this->view->render('menu/index', ['all' => $menus, 'ordered' => $menusOrdered]);
    }

    public function crear()
    {
        if (!$this->existPOST(['nombre', 'descripcion'])) {
            $this->redirect('menu',
                ['error' => \Core\Error::ERROR_MENU_DATOS_FALTANTES]);
            return;
        }

        $menu = new MenuModel();
        $menu->setNombre($this->getPost('nombre'));
        $menu->setDescripcion($this->getPost('descripcion'));

        if (!empty($this->getPost('id_menu_padre'))) {
            $menu->setId_menu_padre($this->getPost('id_menu_padre'));
        }

        if (!$menu->save()) {
            $this->redirect('menu', ['error' => \Core\Error::ERROR_MENU_CREAR]);
            return;
        }
        $this->redirect('menu', ['success' => \Core\Success::SUCCESS_MENU_CREAR]);
    }

    public function actualizar()
    {
        if (!$this->existPOST(['nombre', 'descripcion'])) {
            $this->redirect('menu', ['error' => \Core\Error::ERROR_MENU_DATOS_FALTANTES]);
            return ;
        }

        $menu = new MenuModel();
        $menu->get($this->getPost('id'));

        if (empty($menu->getId())) {
            $this->redirect('menu', ['error' => \Core\Error::ERROR_MENU_DATOS_FALTANTES]);
            return;
        }

        $menu->setNombre($this->getPost('nombre'));
        $menu->setDescripcion($this->getPost('descripcion'));

        if (!empty($this->getPost('id_menu_padre'))) {
            $menu->setId_menu_padre($this->getPost('id_menu_padre'));
        } else {
            $menu->setId_menu_padre(NULL);
        }

        if (!$menu->update()) {
            $this->redirect('menu', ['success' => \Core\Error::ERROR_MENU_ACTUALIZAR]);
            return;
        }
        $this->redirect('menu', ['success' => \Core\Success::SUCCESS_MENU_ACTUALIZAR]);
    }

    public function obtenerMenuJson()
    {
        header('Content-Type: application/json');
        if (!$this->existPOST(['id'])) {
            echo json_encode(['error' => true, 'message' => "No sé encontrarón los datos necesarios para realizar la acción."]);
            return;
        }
        $menu = new MenuModel();
        $menu->get($this->getPost('id'));
        $menu->setChilds($menu->obtenerMenusHijos($this->getPost('id')));

        echo json_encode($menu->fromArray($menu));
    }

    public function eliminar()
    {
        if (!$this->existPOST(['id'])) {
            $this->redirect('menu', ['error' => \Core\Error::ERROR_MENU_DATOS_FALTANTES]);
            return;
        }

        $menu = new MenuModel();
        $menu->get($this->getPost('id'));

        if (empty($menu->getId())) {
            $this->redirect('menu', ['error' => \Core\Error::ERROR_MENU_DATOS_FALTANTES]);
            return;
        }

        $id = $menu->getId();
        if (!$menu->delete($id)) {
            $this->redirect('menu', ['error' => \Core\Error::ERROR_MENU_ELIMINAR]);
            return;
        }

        $this->redirect('menu', ['success' => \Core\Success::SUCCESS_MENU_ELIMINAR]);
    }
}
