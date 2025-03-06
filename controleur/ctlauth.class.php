<?php
require_once 'modele/auth.class.php';
require_once 'modele/Reservation.class.php';
require_once 'modele/egames.class.php';

class CtlAuth {
    private $auth;

    public function __construct() {
        $this->auth = new Auth();
    }

    public function showLoginForm() {
        $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : '';
        $page = new Vue("Connexion");
        $page->afficher(['redirect' => $redirect]);
    }

    public function showRegisterForm() {
        $page = new Vue("Inscription");
        $page->afficher([]);
    }

    /**
     * Traite la soumission du formulaire de connexion
     */
    public function processLogin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];
            $redirect = filter_input(INPUT_POST, 'redirect', FILTER_SANITIZE_URL);

            if ($email && $password) {
                $result = $this->auth->login($email, $password);
                
                if ($result['success']) {
                    // Rediriger vers la page précédente si elle existe
                    if (!empty($redirect)) {
                        header('Location: ' . $redirect);
                    } else {
                        header('Location: index.php');
                    }
                    exit();
                } else {
                    $page = new Vue("Connexion");
                    $page->afficher([
                        'error' => $result['message'],
                        'redirect' => $redirect
                    ]);
                }
            } else {
                $page = new Vue("Connexion");
                $page->afficher([
                    'error' => 'Veuillez remplir tous les champs',
                    'redirect' => $redirect
                ]);
            }
        } else {
            $this->showLoginForm();
        }
    }

    /**
     * Traite la soumission du formulaire d'inscription
     */
    public function processRegister() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $username = htmlspecialchars($_POST['username'] ?? '', ENT_QUOTES, 'UTF-8');
            $password = $_POST['password'];

            if ($email && $username && $password) {
                $result = $this->auth->register($email, $username, $password);
                
                if ($result['success']) {
                    // Connexion automatique après inscription
                    $loginResult = $this->auth->login($email, $password);
                    header('Location: index.php');
                    exit();
                } else {
                    $page = new Vue("Inscription");
                    $page->afficher(['error' => $result['message']]);
                }
            } else {
                $page = new Vue("Inscription");
                $page->afficher(['error' => 'Veuillez remplir tous les champs']);
            }
        } else {
            $this->showRegisterForm();
        }
    }

    /**
     * Déconnecte l'utilisateur
     */
    public function logout() {
        $this->auth->logout();
    }

    /**
     * Affiche le profil de l'utilisateur
     */
    public function showProfile() {
        if (!$this->auth->isLoggedIn()) {
            header('Location: index.php?action=login');
            exit();
        }

        $currentUser = $this->auth->getCurrentUser();
        if (!$currentUser) {
            header('Location: index.php?action=login');
            exit();
        }

        // Récupérer les informations complètes et à jour de l'utilisateur
        $userInfo = $this->auth->getUserById($currentUser['id']);
        if (!$userInfo) {
            header('Location: index.php?action=login');
            exit();
        }

        $reservationinfo = new Reservation();
        $reservationinfo = $reservationinfo -> getUserReservations($currentUser['id']);

        $egamesinstances = new Egames();
        $egames = $egamesinstances->getAllEgames();
        
        $page = new Vue("Profil");
        $page->afficher(['user' => $userInfo, 'reservationinfo' => $reservationinfo, 'egames' => $egames]);
    }

    /**
     * Met à jour la photo de profil
     */
    public function updateProfilePicture() {
        if (!$this->auth->isLoggedIn()) {
            header('Location: index.php?action=login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photo'])) {
            $user = $this->auth->getCurrentUser();
            $file = $_FILES['photo'];
            
            // Vérification du type de fichier
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($file['type'], $allowedTypes)) {
                $page = new Vue("Profil");
                $page->afficher([
                    'user' => $user,
                    'error' => 'Type de fichier non autorisé. Utilisez JPG, PNG ou GIF.'
                ]);
                return;
            }

            // Vérification de la taille du fichier (5 Mo maximum)
            $maxSize = 5 * 1024 * 1024; // 5 Mo en octets
            if ($file['size'] > $maxSize) {
                $page = new Vue("Profil");
                $page->afficher([
                    'user' => $user,
                    'error' => 'L\'image est trop volumineuse. Taille maximum : 5 Mo'
                ]);
                return;
            }

            // Génération d'un nom unique pour le fichier
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $newFileName = uniqid() . '.' . $extension;
            $uploadPath = 'images/profils/' . $newFileName;

            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                // Supprimer l'ancienne photo si ce n'est pas la photo par défaut
                if ($user['photo_profil'] !== 'default.jpg' && file_exists('images/profils/' . $user['photo_profil'])) {
                    unlink('images/profils/' . $user['photo_profil']);
                }

                if ($this->auth->updateProfilePicture($user['id'], $newFileName)) {
                    header('Location: index.php?action=profile');
                    exit();
                }
            }

            $page = new Vue("Profil");
            $page->afficher([
                'user' => $user,
                'error' => 'Erreur lors du téléchargement de l\'image'
            ]);
        }
    }
}
