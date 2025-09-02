<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
</script>

<template>
  <div>
    <div class="min-vh-100 bg-light">
      <nav class="border-bottom border-light bg-white">
        <!-- Primary Navigation Menu -->
        <div class="container-fluid container-lg px-3">
          <div class="d-flex h-16 justify-content-between">
            <div class="d-flex">
              <!-- Logo -->
              <div class="d-flex align-items-center">
                <Link :href="route('dashboard')">
                <ApplicationLogo class="d-block h-9 w-auto text-dark" />
                </Link>
              </div>

              <!-- Navigation Links -->
              <div class="d-none d-sm-flex mx-4">
                <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                  Dashboard
                </NavLink>
              </div>
            </div>

            <div class="d-none d-sm-flex align-items-center ms-auto">
              <!-- Settings Dropdown -->
              <div class="ms-3">
                <Dropdown align="right" width="48">
                  <template #trigger>
                    <button type="button"
                      class="d-inline-flex align-items-center btn btn-light btn-sm text-secondary fw-medium dropdown-toggle">
                      {{ $page.props.auth.user.name }}
                    </button>
                  </template>

                  <template #content>
                    <DropdownLink :href="route('profile.edit')">
                      Profile
                    </DropdownLink>
                    <DropdownLink :href="route('logout')" method="post" as="button">
                      Log Out
                    </DropdownLink>
                  </template>
                </Dropdown>
              </div>
            </div>

            <!-- Hamburger -->
            <div class="d-flex d-sm-none align-items-center">
              <button @click="
                showingNavigationDropdown =
                !showingNavigationDropdown
                "
                class="btn btn-light d-inline-flex align-items-center justify-content-center rounded p-2 text-secondary">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                  <path :class="{
                    'd-none': showingNavigationDropdown,
                    'd-inline-flex':
                      !showingNavigationDropdown,
                  }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                  <path :class="{
                    'd-none': !showingNavigationDropdown,
                    'd-inline-flex':
                      showingNavigationDropdown,
                  }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
          </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div :class="{
          'd-block': showingNavigationDropdown,
          'd-none': !showingNavigationDropdown,
        }" class="d-sm-none">
          <div class="py-2 mb-2">
            <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
              Dashboard
            </ResponsiveNavLink>
          </div>

          <!-- Responsive Settings Options -->
          <div class="border-top border-light py-3">
            <div class="px-3">
              <div class="fs-6 fw-medium text-dark">
                {{ $page.props.auth.user.name }}
              </div>
              <div class="small fw-medium text-secondary">
                {{ $page.props.auth.user.email }}
              </div>
            </div>

            <div class="mt-3">
              <ResponsiveNavLink :href="route('profile.edit')">
                Profile
              </ResponsiveNavLink>
              <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                Log Out
              </ResponsiveNavLink>
            </div>
          </div>
        </div>
      </nav>

      <!-- Page Heading -->
      <header class="bg-white shadow" v-if="$slots.header">
        <div class="container-fluid container-lg py-4">
          <slot name="header" />
        </div>
      </header>

      <!-- Page Content -->
      <main>
        <slot />
      </main>
    </div>
  </div>
</template>
