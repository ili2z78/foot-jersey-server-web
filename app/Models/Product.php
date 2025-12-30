<?php

class Product extends Model {

    public function all() {
        $stmt = self::$db->query("SELECT * FROM products");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($slug) {
        $stmt = self::$db->prepare("SELECT * FROM products WHERE slug = ?");
        $stmt->execute([$slug]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function search($query, $limit = null, $offset = 0) {
        $sql = "SELECT * FROM products WHERE name LIKE ? OR description LIKE ?";

        if ($limit !== null) {
            $sql .= " LIMIT ? OFFSET ?";
        }

        $stmt = self::$db->prepare($sql);
        $params = ["%$query%", "%$query%"];

        if ($limit !== null) {
            $params[] = (int)$limit;
            $params[] = (int)$offset;
        }

        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countSearchResults($query) {
        $stmt = self::$db->prepare("SELECT COUNT(*) as count FROM products WHERE name LIKE ? OR description LIKE ?");
        $stmt->execute(["%$query%", "%$query%"]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    }

    public function findByCategory($categoryId, $limit = null, $offset = 0, $sort = 'name') {
        $sql = "SELECT * FROM products WHERE category_id = ?";

        $orderBy = $this->getOrderBy($sort);
        $sql .= " ORDER BY $orderBy";

        if ($limit !== null) {
            $sql .= " LIMIT ? OFFSET ?";
        }

        $stmt = self::$db->prepare($sql);
        $params = [$categoryId];

        if ($limit !== null) {
            $params[] = (int)$limit;
            $params[] = (int)$offset;
        }

        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByCategorySlug($categorySlug, $limit = null, $offset = 0, $sort = 'name') {
        $sql = "SELECT p.* FROM products p JOIN categories c ON p.category_id = c.id WHERE c.slug = :categorySlug";

        $orderBy = $this->getOrderBy($sort);
        $sql .= " ORDER BY $orderBy";

        if ($limit !== null) {
            $sql .= " LIMIT :limit OFFSET :offset";
        }

        $stmt = self::$db->prepare($sql);
        $stmt->bindValue(':categorySlug', $categorySlug, PDO::PARAM_STR);

        if ($limit !== null) {
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countByCategory($categoryId) {
        $stmt = self::$db->prepare("SELECT COUNT(*) as count FROM products WHERE category_id = ?");
        $stmt->execute([(int)$categoryId]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    }

    public function countByCategorySlug($categorySlug) {
        $stmt = self::$db->prepare("SELECT COUNT(*) as count FROM products p JOIN categories c ON p.category_id = c.id WHERE c.slug = ?");
        $stmt->execute([$categorySlug]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    }

    public function paginate($limit, $offset = 0, $sort = 'name') {
        $sql = "SELECT * FROM products";

        $orderBy = $this->getOrderBy($sort);
        $sql .= " ORDER BY $orderBy LIMIT ? OFFSET ?";

        $stmt = self::$db->prepare($sql);
        $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(2, (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getOrderBy($sort) {
        switch ($sort) {
            case 'price-low':
                return 'price ASC';
            case 'price-high':
                return 'price DESC';
            case 'newest':
                return 'created_at DESC';
            case 'name':
            default:
                return 'name ASC';
        }
    }

    public function countAll() {
        $stmt = self::$db->query("SELECT COUNT(*) as count FROM products");
        return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    }
}
