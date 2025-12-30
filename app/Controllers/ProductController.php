<?php

require_once __DIR__ . '/../Helpers/auth.php';

class ProductController {

    protected $productModel;

    public function __construct() {
        if (!class_exists('Product')) {
            require_once __DIR__ . '/../Models/Product.php';
        }
        if (!class_exists('Model')) {
            require_once __DIR__ . '/../Models/Model.php';
        }
        $this->productModel = new Product();
    }

    private function getCategories() {
        $stmt = Model::$db->query("SELECT id, name, slug FROM categories ORDER BY name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Liste des produits (catalogue)
     * Options:
     *  - ?q=searchterm pour recherche
     *  - ?category=slug pour filtrer par catégorie (si implémentée)
     *  - pagination basique via ?page_num=
     */
    public function list() {
        $q = trim($_GET['q'] ?? '');
        $category = trim($_GET['category'] ?? '');
        $sort = trim($_GET['sort'] ?? 'name');
        $pageNum = max(1, (int)($_GET['page_num'] ?? 1));
        $perPage = 12;
        $offset = ($pageNum - 1) * $perPage;

        if ($q !== '' && method_exists($this->productModel, 'search')) {
            $products = $this->productModel->search($q, $perPage, $offset);
            $total = $this->productModel->countSearchResults($q);
        } elseif ($category !== '' && method_exists($this->productModel, 'findByCategorySlug')) {
            $products = $this->productModel->findByCategorySlug($category, $perPage, $offset, $sort);
            $total = $this->productModel->countByCategorySlug($category);
        } else {
            if (method_exists($this->productModel, 'paginate')) {
                $products = $this->productModel->paginate($perPage, $offset, $sort);
                $total = $this->productModel->countAll();
            } else {
                $products = $this->productModel->all();
                $total = count($products);
            }
        }

        $totalPages = ($perPage > 0) ? (int)ceil($total / $perPage) : 1;

        $categories = $this->getCategories();

        require __DIR__ . '/../Views/products/list.php';
    }

    /**
     * Page détail produit
     * Lecture via slug (param ?slug=...) ou id (?id=...)
     */
    public function detail() {
        $slug = $_GET['slug'] ?? null;
        $id = $_GET['id'] ?? null;

        if ($slug) {
            $p = $this->productModel->find($slug);
        } elseif ($id) {
            if (method_exists($this->productModel, 'findById')) {
                $p = $this->productModel->findById((int)$id);
            } else {
                $p = $this->productModel->find((int)$id);
            }
        } else {
            header('Location: /?page=product&action=list');
            exit;
        }

        if (!$p) {
            http_response_code(404);
            echo "Produit non trouvé";
            exit;
        }

        require __DIR__ . '/../Views/products/detail.php';
    }

    /**
     * Short helper pour redirection vers la page produit (utilisé par d'autres controllers)
     */
    public static function redirectToProduct($product) {
        if (isset($product['slug'])) {
            header('Location: /?page=product&action=detail&slug=' . urlencode($product['slug']));
        } else {
            header('Location: /?page=product&action=list');
        }
        exit;
    }
}
