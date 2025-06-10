<?php

namespace App\Http\Controllers;

use App\User;
use App\Teacher;
use App\Student;
use App\Parents;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class RoleAssign extends Controller
{

    public function index()
    {
        $users = User::with('roles')->latest()->paginate(10);

        return view('backend.assignrole.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::latest()->get();
        
        return view('backend.assignrole.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users',
            'password'  => 'required|string|min:8',
            'role'      => 'required|string|exists:roles,name',
        ]);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'profile_picture' => 'avatar.png'
        ]);

        // Assigner le rôle
        $user->assignRole($request->role);

        // Créer le profil spécialisé selon le rôle
        $this->createSpecializedProfile($user, $request->role);

        return redirect()->route('assignrole.index')
                        ->with('success', 'Utilisateur créé avec succès avec le profil ' . $request->role);
    }

    /**
     * Créer le profil spécialisé selon le rôle
     */
    private function createSpecializedProfile(User $user, string $role)
    {
        switch (strtolower($role)) {
            case 'teacher':
                Teacher::create([
                    'user_id' => $user->id,
                    'gender' => 'male',
                    'phone' => 'Non renseigné',
                    'dateofbirth' => now()->subYears(30)->format('Y-m-d'), // 30 ans par défaut
                    'current_address' => 'Adresse non renseignée',
                    'permanent_address' => 'Adresse non renseignée',
                ]);
                break;

            case 'student':
                // Créer d'abord un parent par défaut si nécessaire
                $defaultParent = $this->getOrCreateDefaultParent();
                
                Student::create([
                    'user_id' => $user->id,
                    'parent_id' => $defaultParent->id,
                    'class_id' => $this->getDefaultClassId(),
                    'roll_number' => $this->generateStudentRollNumber(),
                    'gender' => 'male',
                    'phone' => 'Non renseigné',
                    'dateofbirth' => now()->subYears(18)->format('Y-m-d'), // 18 ans par défaut
                    'current_address' => 'Adresse non renseignée',
                    'permanent_address' => 'Adresse non renseignée',
                ]);
                break;

            case 'parent':
                Parents::create([
                    'user_id' => $user->id,
                    'gender' => 'male',
                    'phone' => 'Non renseigné',
                    'current_address' => 'Adresse non renseignée',
                    'permanent_address' => 'Adresse non renseignée',
                ]);
                break;

            default:
                // Pour les autres rôles (Admin, etc.), pas de profil spécialisé
                break;
        }
    }

    /**
     * Obtenir ou créer un parent par défaut pour les étudiants
     */
    private function getOrCreateDefaultParent()
    {
        // Chercher un parent système existant
        $systemParent = Parents::whereHas('user', function($query) {
            $query->where('email', 'system.parent@edumanage.local');
        })->first();

        if (!$systemParent) {
            // Créer un parent système
            $parentUser = User::create([
                'name' => 'Parent Système',
                'email' => 'system.parent@edumanage.local',
                'password' => Hash::make('system123'),
                'profile_picture' => 'avatar.png'
            ]);

            $parentUser->assignRole('Parent');

            $systemParent = Parents::create([
                'user_id' => $parentUser->id,
                'gender' => 'male',
                'phone' => 'Système',
                'current_address' => 'Adresse système',
                'permanent_address' => 'Adresse système',
            ]);
        }

        return $systemParent;
    }

    /**
     * Obtenir l'ID de classe par défaut
     */
    private function getDefaultClassId()
    {
        $defaultClass = \App\Grade::where('class_name', 'Classe Générale')->first();
        
        if (!$defaultClass) {
            // Créer une classe par défaut si elle n'existe pas
            $defaultTeacher = Teacher::first();
            
            $defaultClass = \App\Grade::create([
                'class_name' => 'Classe Générale',
                'class_numeric' => 0,
                'teacher_id' => $defaultTeacher ? $defaultTeacher->id : 1,
                'status' => 1,
            ]);
        }
        
        return $defaultClass->id;
    }

    /**
     * Générer un numéro de matricule pour l'étudiant
     */
    private function generateStudentRollNumber()
    {
        $year = date('Y');
        $lastStudent = Student::where('roll_number', 'like', $year . '%')
                             ->orderBy('roll_number', 'desc')
                             ->first();

        if ($lastStudent && preg_match('/(\d+)$/', $lastStudent->roll_number, $matches)) {
            $lastNumber = intval($matches[1]);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $year . str_pad($newNumber, 6, '0', STR_PAD_LEFT);
    }

    public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::latest()->get();
        
        return view('backend.assignrole.edit', compact('user','roles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'selectedrole' => 'required|array|min:1',
            'selectedrole.*' => 'exists:roles,name'
        ], [
            'selectedrole.required' => 'Veuillez sélectionner au moins un rôle.',
            'selectedrole.min' => 'Veuillez sélectionner au moins un rôle.',
            'selectedrole.*.exists' => 'Un des rôles sélectionnés n\'existe pas.'
        ]);

        $user = User::findOrFail($id);
        $oldRoles = $user->roles->pluck('name')->toArray();

        $user->update([
            'name'  => $request->name,
            'email' => $request->email
        ]);

        // Synchroniser les rôles
        $user->syncRoles($request->selectedrole);

        // Gérer les changements de profils spécialisés
        $this->handleRoleChanges($user, $oldRoles, $request->selectedrole);

        return redirect()->route('assignrole.index')
                        ->with('success', 'Utilisateur mis à jour avec succès. Nouveaux rôles : ' . implode(', ', $request->selectedrole));
    }

    /**
     * Gérer les changements de rôles et profils
     */
    private function handleRoleChanges(User $user, array $oldRoles, array $newRoles)
    {
        $addedRoles = array_diff($newRoles, $oldRoles);
        $removedRoles = array_diff($oldRoles, $newRoles);

        // Créer les nouveaux profils
        foreach ($addedRoles as $role) {
            if (!$this->userHasSpecializedProfile($user, $role)) {
                $this->createSpecializedProfile($user, $role);
            }
        }

        // Optionnel : Supprimer les anciens profils si nécessaire
        foreach ($removedRoles as $role) {
            $this->removeSpecializedProfile($user, $role);
        }
    }

    /**
     * Vérifier si l'utilisateur a déjà le profil spécialisé
     */
    private function userHasSpecializedProfile(User $user, string $role): bool
    {
        switch (strtolower($role)) {
            case 'teacher':
                return $user->teacher !== null;
            case 'student':
                return $user->student !== null;
            case 'parent':
                return $user->parent !== null;
            default:
                return true; // Pas de profil spécialisé requis
        }
    }

    /**
     * Supprimer le profil spécialisé
     */
    private function removeSpecializedProfile(User $user, string $role)
    {
        switch (strtolower($role)) {
            case 'teacher':
                if ($user->teacher) {
                    $user->teacher->delete();
                }
                break;
            case 'student':
                if ($user->student) {
                    $user->student->delete();
                }
                break;
            case 'parent':
                if ($user->parent) {
                    $user->parent->delete();
                }
                break;
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Supprimer tous les profils spécialisés
        if ($user->teacher) $user->teacher->delete();
        if ($user->student) $user->student->delete();
        if ($user->parent) $user->parent->delete();
        
        // Supprimer tous les rôles
        $user->syncRoles([]);
        
        // Supprimer l'image de profil si ce n'est pas l'avatar par défaut
        if ($user->profile_picture && $user->profile_picture !== 'avatar.png') {
            $image_path = public_path() . '/images/profile/' . $user->profile_picture;
            if (is_file($image_path) && file_exists($image_path)) {
                unlink($image_path);
            }
        }
        
        $user->delete();

        return back()->with('success', 'Utilisateur supprimé avec succès');
    }
}