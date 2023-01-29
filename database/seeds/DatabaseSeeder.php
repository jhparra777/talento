<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
         $this->call(UnidadTrabajoTableSeeder::class);
         $this->call(ConceptosPagosTableSeeder::class);
         $this->call(EstadosTableSeeder::class);
         $this->call(MotivosRetirosTableSeeder::class);
         $this->call(EntidadesEpsTableSeeder::class);
         $this->call(EscolaridadesTableSeeder::class);
         $this->call(TiposPruebasTableSeeder::class);
         $this->call(ParentescosTableSeeder::class);
         $this->call(PreliminarTransversalesTableSeeder::class);
         $this->call(TiposDocumentosTableSeeder::class);
         $this->call(TipoRelacionesTableSeeder::class);
         $this->call(ProfesionesTableSeeder::class);
         $this->call(EntidadesAfpTableSeeder::class);
         $this->call(MotivoRequerimientoTableSeeder::class);
         $this->call(MotivosRechazosTableSeeder::class);
         $this->call(GerenciaTableSeeder::class);
         $this->call(TipoFuenteTableSeeder::class);
         $this->call(TiposExperienciasTableSeeder::class);
         $this->call(NivelesEstudiosTableSeeder::class);
         $this->call(TiposLiquidacionesTableSeeder::class);
         $this->call(TiposNominasTableSeeder::class);
         $this->call(CentrosCostosProduccionTableSeeder::class);
         $this->call(CentrosTrabajosTableSeeder::class);
         $this->call(TiposJornadasTableSeeder::class);
         $this->call(UnidadesNegociosTableSeeder::class);
         $this->call(SociedadesTableSeeder::class);
         $this->call(LocalidadesTableSeeder::class);
         $this->call(TipoNegocioTableSeeder::class);
         $this->call(TipoPreguntaTableSeeder::class);
         $this->call(TiposContratosTableSeeder::class);
         $this->call(TipoProcesoTableSeeder::class);
         $this->call(TiposSalariosTableSeeder::class);
         $this->call(TiposCargosTableSeeder::class);
         $this->call(PaisesTableSeeder::class);
         $this->call(DepartamentosTableSeeder::class);
         $this->call(CiudadesTableSeeder::class);
         $this->call(UsersTableSeeder::class);
         $this->call(AspiracionSalarialTableSeeder::class);
         $this->call(TipoIdentificacionTableSeeder::class);
         $this->call(GeneroTableSeeder::class);
         $this->call(EstadosCivilesTableSeeder::class);
         $this->call(DatosBasicosTableSeeder::class);
         $this->call(RolesTableSeeder::class);
         $this->call(RoleUsersTableSeeder::class);
         $this->call(ActivationsTableSeeder::class);
         $this->call(SitioTableSeeder::class);

        Model::reguard();
    }
}
