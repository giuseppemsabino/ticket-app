<script setup>
import { Head, Link } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
//Layout
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

//Components
import UserDashboards from '@/Components/Dashboards/UserDashboards.vue';
import Admin_techDashboard from '@/Components/Dashboards/Admin_techDashboard.vue';



//Props
const props = defineProps({
  tickets: Array,
  userLog: Object,
  statuses: Array,
  comments: Array
});

const role = props.userLog?.role_id ?? '—';

</script>

<template>

  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header class="header">
      <h2 class="fs-4 fw-semibold">Dashboard</h2>
    </template>

    <div class="py-4">
      <div class="container-fluid container-lg">
        <div class="row">

          <!-- Profile details-->
          <div class="col-4">
            <div class="border-top border-light py-3">
              <h3>UTENTE</h3>
              <img src="https://upload.wikimedia.org/wikipedia/commons/8/89/Portrait_Placeholder.png" alt=""
                style="width:200px ;">
              <div class="px-3">
                <div class="fs-6 fw-medium text-dark">
                  {{ $page.props.auth.user.name }}
                </div>
                <div class="small fw-medium text-secondary">
                  {{ $page.props.auth.user.email }}
                </div>
              </div>

              <div class=" d-flex flex-column gap-2 px-3">

              </div>
            </div>
          </div>

          <!-- Dashboard content-->
          <div class="col-7">

            <!-- User Dashboard -->
            <div v-if="role === 1">
              <UserDashboards :tickets="props.tickets" :user-log="props.userLog" :statuses="props.statuses"
                :comments="props.comments" />
            </div>

            <!-- Admin / Technician Dashboard -->
            <div v-else="role === 2 || role === 3 || role === 4">
              <Admin_techDashboard />

            </div>


          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
