<script setup>
import { Head, Link } from '@inertiajs/vue3';

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
            PROFILO UTENTE
            <div>{{ props.userLog?.name ?? '—' }}</div>
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
