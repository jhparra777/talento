<?php

namespace App\Models;

use Cartalyst\Sentinel\Permissions\PermissibleInterface;
use Cartalyst\Sentinel\Permissions\PermissibleTrait;
use Cartalyst\Sentinel\Persistences\PersistableInterface;
use Cartalyst\Sentinel\Roles\RoleableInterface;
use Cartalyst\Sentinel\Roles\RoleInterface;
use Cartalyst\Sentinel\Users\UserInterface;
use App\Models\Solicitudes;
use App\Models\AgenciaUsuario;
use DB;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements RoleableInterface, PermissibleInterface, PersistableInterface, UserInterface
{

    use PermissibleTrait;

    /**
     * {@inheritDoc}
     */
    protected $table = 'users';

    /**
     * {@inheritDoc}
     */

    protected $fillable = [
        'name', 'email', 'password', 'remember_token', 'hash_verificacion', 'username', 'numero_id', 'facebook_key', 'google_key', 'foto_perfil', 'estado', 'padre_id', 'permissions', 'last_login', 'pais_id', 'departamento_id', 'ciudad_id', 'notificacion_requisicion', 'nickname', 'cedula', 'correo_corporativo', 'telefono', 'unidad_trabajo', 'avatar','video_perfil','api_token','ip_registro',"metodo_carga","usuario_carga","tipo_fuente_id"
    ];

    /**
     * {@inheritDoc}
     */
    protected $hidden = [
        'password',
    ];

    /**
     * {@inheritDoc}
     */
    protected $persistableKey = 'user_id';

    /**
     * {@inheritDoc}
     */
    protected $persistableRelationship = 'persistences';

    /**
     * Array of login column names.
     *
     * @var array
     */
    protected $loginNames = ['username', "email", "numero_id"];

    /**
     * The Eloquent roles model name.
     *
     * @var string
     */
    protected static $rolesModel = 'Cartalyst\Sentinel\Roles\EloquentRole';

    /**
     * The Eloquent persistences model name.
     *
     * @var string
     */
    protected static $persistencesModel = 'Cartalyst\Sentinel\Persistences\EloquentPersistence';

    /**
     * The Eloquent activations model name.
     *
     * @var string
     */
    protected static $activationsModel = 'Cartalyst\Sentinel\Activations\EloquentActivation';

    /**
     * The Eloquent reminders model name.
     *
     * @var string
     */
    protected static $remindersModel = 'Cartalyst\Sentinel\Reminders\EloquentReminder';

    /**
     * The Eloquent throttling model name.
     *
     * @var string
     */
    protected static $throttlingModel = 'Cartalyst\Sentinel\Throttling\EloquentThrottle';

    /**
     * Returns an array of login column names.
     *
     * @return array
     */
    public function metodo_de_carga(){
        $this->belongsTo('App\Models\MetodoCarga','metodo_carga');
    }

    public function getLoginNames()
    {
        return $this->loginNames;
    }

    /**
     * Returns the roles relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(static::$rolesModel, 'role_users', 'user_id', 'role_id')->withTimestamps();
    }

    public function roles2()
    {
        return $this->belongsToMany("App\Models\Role", 'role_users', 'user_id', 'role_id');
    }
    /**
     * Returns the persistences relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function persistences()
    {
        return $this->hasMany(static::$persistencesModel, 'user_id');
    }

    public function solicitudes()
    {
        return $this->hasMany("App\Models\Solicitudes");
    }

    public function clientes_users()
    {
        $clientes = UserClientes::select('cliente_id')->where('user_id', $this->id)->pluck("cliente_id")->toArray();

        return $clientes;
    }

    public function agencias()
    {
        if($this->id != 34409){
            $agencias = AgenciaUsuario::select('id_agencia')->where('id_usuario', $this->id)->pluck("id_agencia")->toArray();
        }else{
            $agencias = AgenciaUsuario::select('id_agencia')->pluck("id_agencia")->toArray();
        }

        return $agencias;
    }

    public function agencias2(){
       return $this->belongsToMany('App\Models\Agencia', 'agencia_usuario','id_usuario','id_agencia');
    }

    public function clientes(){
       return $this->belongsToMany('App\Models\Clientes', 'users_x_clientes','user_id','cliente_id');
    }
    

    /**
     * Returns the activations relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activations()
    {
        return $this->hasMany(static::$activationsModel, 'user_id');
    }

    /**
     * Returns the reminders relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reminders()
    {
        return $this->hasMany(static::$remindersModel, 'user_id');
    }

    /**
     * Returns the throttle relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function throttle()
    {
        return $this->hasMany(static::$throttlingModel, 'user_id');
    }

    /**
     * Get mutator for the "permissions" attribute.
     *
     * @param  mixed  $permissions
     * @return array
     */
    public function getPermissionsAttribute($permissions)
    {
        return $permissions ? json_decode($permissions, true) : [];
    }

    /**
     * Set mutator for the "permissions" attribute.
     *
     * @param  mixed  $permissions
     * @return void
     */
    public function setPermissionsAttribute(array $permissions)
    {
        $this->attributes['permissions'] = $permissions ? json_encode($permissions) : '';
    }

    /**
     * {@inheritDoc}
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * {@inheritDoc}
     */
    public function inRole($role)
    {
        $role = array_first($this->roles, function ($instance,$index) use ($role) {
            if ($role instanceof RoleInterface) {
                return ($instance->getRoleId() === $role->getRoleId());
            }


            if ($instance->getRoleId() == $role || $instance->getRoleSlug() == $role) {
                return true;
            }

            return false;
        });

      //  dd($role);

        return $role !== null;
    }

    /**
     * {@inheritDoc}
     */
    public function generatePersistenceCode()
    {
        return str_random(32);
    }

    /**
     * {@inheritDoc}
     */
    public function getUserId()
    {
        return $this->getKey();
    }

    /**
     * {@inheritDoc}
     */
    public function getPersistableId()
    {
        return $this->getKey();
    }

    /**
     * {@inheritDoc}
     */
    public function getPersistableKey()
    {
        return $this->persistableKey;
    }

    /**
     * {@inheritDoc}
     */
    public function setPersistableKey($key)
    {
        $this->persistableKey = $key;
    }

    /**
     * {@inheritDoc}
     */
    public function setPersistableRelationship($persistableRelationship)
    {
        $this->persistableRelationship = $persistableRelationship;
    }

    /**
     * {@inheritDoc}
     */
    public function getPersistableRelationship()
    {
        return $this->persistableRelationship;
    }

    /**
     * {@inheritDoc}
     */
    public function getUserLogin()
    {
        return $this->getAttribute($this->getUserLoginName());
    }

    /**
     * {@inheritDoc}
     */
    public function getUserLoginName()
    {
        return reset($this->loginNames);
    }

    /**
     * {@inheritDoc}
     */
    public function getUserPassword()
    {
        return $this->password;
    }

    /**
     * Returns the roles model.
     *
     * @return string
     */
    public static function getRolesModel()
    {
        return static::$rolesModel;
    }

    /**
     * Sets the roles model.
     *
     * @param  string  $rolesModel
     * @return void
     */
    public static function setRolesModel($rolesModel)
    {
        static::$rolesModel = $rolesModel;
    }

    /**
     * Returns the persistences model.
     *
     * @return string
     */
    public static function getPersistencesModel()
    {
        return static::$persistencesModel;
    }

    /**
     * Sets the persistences model.
     *
     * @param  string  $persistencesModel
     * @return void
     */
    public static function setPersistencesModel($persistencesModel)
    {
        static::$persistencesModel = $persistencesModel;
    }

    /**
     * Returns the activations model.
     *
     * @return string
     */
    public static function getActivationsModel()
    {
        return static::$activationsModel;
    }

    /**
     * Sets the activations model.
     *
     * @param  string  $activationsModel
     * @return void
     */
    public static function setActivationsModel($activationsModel)
    {
        static::$activationsModel = $activationsModel;
    }

    /**
     * Returns the reminders model.
     *
     * @return string
     */
    public static function getRemindersModel()
    {
        return static::$remindersModel;
    }

    /**
     * Sets the reminders model.
     *
     * @param  string  $remindersModel
     * @return void
     */
    public static function setRemindersModel($remindersModel)
    {
        static::$remindersModel = $remindersModel;
    }

    /**
     * Returns the throttling model.
     *
     * @return string
     */
    public static function getThrottlingModel()
    {
        return static::$throttlingModel;
    }

    /**
     * Sets the throttling model.
     *
     * @param  string  $throttlingModel
     * @return void
     */
    public static function setThrottlingModel($throttlingModel)
    {
        static::$throttlingModel = $throttlingModel;
    }

    /**
     * {@inheritDoc}
     */
    public function delete()
    {
        $isSoftDeleted = array_key_exists('Illuminate\Database\Eloquent\SoftDeletes', class_uses($this));

        if ($this->exists && !$isSoftDeleted) {
            $this->activations()->delete();
            $this->persistences()->delete();
            $this->reminders()->delete();
            $this->roles()->detach();
            $this->throttle()->delete();
        }

        return parent::delete();
    }

    /**
     * Dynamically pass missing methods to the user.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        $methods = ['hasAccess', 'hasAnyAccess'];

        if (in_array($method, $methods)) {
            $permissions = $this->getPermissionsInstance();

            return call_user_func_array([$permissions, $method], $parameters);
        }

        return parent::__call($method, $parameters);
    }

    /**
     * Creates a permissions object.
     *
     * @return \Cartalyst\Sentinel\Permissions\PermissionsInterface
     */
    protected function createPermissions()
    {
        $userPermissions = $this->permissions;

        $rolePermissions = [];

        foreach ($this->roles as $role) {
            $rolePermissions[] = $role->permissions;
        }

        return new static::$permissionsClass($userPermissions, $rolePermissions);
    }

    public function getCedula()
    {
        return $this->hasOne("App\Models\DatosBasicos", "user_id")->first();
    }

    public function getDatosBasicos()
    {
        return $this->hasOne("App\Models\DatosBasicos", "user_id")->first();
    }

    public function getEmpresa()
    {
        return $this->hasOne("App\Models\UserClientes", "user_id")->join("clientes", "clientes.id", "=", "users_x_clientes.cliente_id")->first();
    }

    public function getEstado()
    {

        $estado = DB::table("estados")->where("id", $this->estado_reclutamiento)->first();

        if ($estado == null) {
            return "";
        }
        return $estado->descripcion;
    }

      public function getProcesos()
    {

        $procesos = DB::table("procesos_candidato_req")->where("requerimiento_candidato_id", $this->req_candidato_id)
        ->orderBy("procesos_candidato_req.id", "asc")
        ->groupBy("procesos_candidato_req.id")
        ->get();

        if ($procesos == null) {
            return "";
        }
        return $procesos;
    }

    public function hasAgencia($usuario,$agencia)
    {

        $agencia = DB::table("agencia_usuario")->where("id_usuario",$usuario)
        ->where("id_agencia",$agencia)
        ->first();

        if ($agencia == null) {
            return false;
        }
        else{
            return true;
        }
        
    }

    public function getObservaciones()
    {

        $observaciones = DB::table("observaciones_candidato")
        ->where("req_can_id", $this->req_candidato_id)
        ->orderBy("observaciones_candidato.id", "asc")
        ->get();

        if ($observaciones == null) {
            return "";
        }
        return $observaciones;
    }

    public function generateToken(){
        $this->api_token = str_random(60);
        $this->save();
        return $this->api_token;
    }

    public function contratacionCompleta(){
        
    }

    public function preperfilamientos(){
       return $this->belongsToMany('App\Models\Requerimiento', 'candidatos_preperfilados','candidato_id','req_id');
    }

}
