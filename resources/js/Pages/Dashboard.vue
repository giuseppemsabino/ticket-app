<script setup>
import { Head } from '@inertiajs/vue3';

//Layout
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

//Components
import UserDashboards from '@/Components/Dashboards/UserDashboards.vue';
import Admin_techDashboard from '@/Components/Dashboards/Admin_techDashboard.vue';
import SuperAdminDashboard from '@/Components/Dashboards/SuperAdminDashboard.vue';


//Props
const props = defineProps({
  tickets: Array,
  userLog: Object,
  statuses: Array,
  comments: Array,
  projects: Array,
});

const role = props.userLog?.role_id ?? '—';
</script>

<template>

  <Head title="Dashboard">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  </Head>

  <AuthenticatedLayout>
    <template #header class="header">
      <h2 class="fs-4 fw-semibold"><i class="fa-solid fa-house"></i> Dashboard</h2>
    </template>

    <!-- Superadmin Dashboard -->
    <div v-if="role === 4">
      <SuperAdminDashboard :users="users" />
    </div>

    <!-- other user Dashboard -->
    <div v-else class="py-4">
      <div class="container-fluid container-lg">
        <div class="row">

          <div class="col-3 border rounded-3 shadow-sm bg-white px-4">

            <!-- Profile details-->
            <div class="border-top border-light py-3">
              <h3>
                <Link href="{{ route('profile.edit') }}" class="text-decoration-none text-dark">
                <i class="fas fa-user me-2"></i>Profilo
                </Link>
              </h3>
              <div class="px-3">
                <div class="fs-6 fw-medium text-dark">
                  {{ $page.props.auth.user.name }}
                </div>
                <div class="small fw-medium text-secondary">
                  {{ $page.props.auth.user.email }}
                </div>
              </div>

              <!--  Project List -->
              <h3 class="mt-5"><i class="fa-solid fa-briefcase me-2"></i>Progetti</h3>
              <div class=" d-flex flex-column gap-2 px-3">
                <div class="projects">
                  <ul class="list-group list-group-flush">
                    <li v-for="project in projects" :key="project.id" class="list-group-item p-1">
                      {{ project.name }}
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>

          <!-- Dashboard content-->
          <div class="col-9">

            <!-- User Dashboard -->
            <div v-if="role === 1">
              <UserDashboards :tickets="props.tickets" :user-log="props.userLog" :statuses="props.statuses"
                :comments="props.comments" />
            </div>

            <!-- Admin / Technician Dashboard -->
            <div v-else-if="role === 2 || role === 3">
              <Admin_techDashboard :tickets="props.tickets" :statuses="props.statuses" :users="props.userLog"
                :areas="props.areas" :projects="props.projects" />
            </div>


          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
