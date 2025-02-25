<?php
session_start();
require "database.class.php";
class Auth extends database {
    
    /**
     * Inscription d'un nouvel utilisateur
     * @param string $email Email de l'utilisateur
     * @param string $username Nom d'utilisateur
     * @param string $password Mot de passe (non hashé)
     * @return array Tableau contenant le statut de l'opération et un message
     */
    public function register($email, $username, $password) {
        // Vérifier si l'email existe déjà
        $checkQuery = "SELECT id FROM utilisateurs WHERE email = ?";
        $result = $this->execReqPrep($checkQuery, [$email]);
        
        if(!empty($result)) {
            return ['success' => false, 'message' => 'Cet email est déjà utilisé'];
        }
        
        // Hash du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Insertion de l'utilisateur
        $insertQuery = "INSERT INTO utilisateurs (email, username, password) VALUES (?, ?, ?)";
        $result = $this->execReqPrep($insertQuery, [$email, $username, $hashedPassword]);
        
        if($result !== false) {
            return ['success' => true, 'message' => 'Inscription réussie'];
        } else {
            return ['success' => false, 'message' => 'Erreur lors de l\'inscription'];
        }
    }

    /**
     * Connexion d'un utilisateur
     * @param string $email Email de l'utilisateur
     * @param string $password Mot de passe
     * @return array Tableau contenant le statut de l'opération et un message
     */
    public function login($email, $password) {
        $query = "SELECT * FROM utilisateurs WHERE email = ?";
        $result = $this->execReqPrep($query, [$email]);
        
        if(!empty($result)) {
            $user = $result[0];
            if(password_verify($password, $user['password'])) {
                // Création de la session
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'email' => $user['email'],
                    'username' => $user['username'],
                    'photo_profil' => $user['photo_profil'],
                    'date_inscription' => $user['date_inscription']
                ];
                return ['success' => true, 'message' => 'Connexion réussie'];
            }
        }
        
        return ['success' => false, 'message' => 'Email ou mot de passe incorrect'];
    }

    /**
     * Déconnexion de l'utilisateur
     */
    public function logout() {
        session_destroy();
        header('Location: index.php');
        exit();
    }

    /**
     * Vérifie si un utilisateur est connecté
     * @return bool
     */
    public function isLoggedIn() {
        return isset($_SESSION['user']);
    }

    /**
     * Récupère les informations de l'utilisateur connecté
     * @return array|null
     */
    public function getCurrentUser() {
        return isset($_SESSION['user']) ? $_SESSION['user'] : null;
    }

    /**
     * Met à jour la photo de profil d'un utilisateur
     * @param int $userId ID de l'utilisateur
     * @param string $photoPath Chemin de la nouvelle photo
     * @return bool
     */
    public function updateProfilePicture($userId, $photoPath) {
        $query = "UPDATE utilisateurs SET photo_profil = ? WHERE id = ?";
        $result = $this->execReqPrep($query, [$photoPath, $userId]);
        
        if($result !== false && isset($_SESSION['user'])) {
            $_SESSION['user']['photo_profil'] = $photoPath;
            return true;
        }
        return false;
    }

    /**
     * Récupère les informations d'un utilisateur par son ID
     * @param int $userId ID de l'utilisateur
     * @return array|null
     */
    public function getUserById($userId) {
        $query = "SELECT * FROM utilisateurs WHERE id = ?";
        $result = $this->execReqPrep($query, [$userId]);
        
        if(!empty($result)) {
            // Mettre à jour la session avec les informations complètes
            $_SESSION['user'] = $result[0];
            return $result[0];
        }
        return null;
    }
}
