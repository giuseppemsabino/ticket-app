<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
  canResetPassword: {
    type: Boolean,
  },
  status: {
    type: String,
  },
});

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const submit = () => {
  form.post(route('login'), {
    onFinish: () => form.reset('password'),
  });
};
</script>

<template>
  <GuestLayout>

    <div v-if="status" class="mb-4 small fw-medium text-success">
      {{ status }}
    </div>

    <form @submit.prevent="submit">
      <div>
        <InputLabel for="email" value="Email" />

        <TextInput id="email" type="email" class="mt-2 form-control w-100" v-model="form.email" required autofocus
          autocomplete="username" />

        <InputError class="mt-2" :message="form.errors.email" />
      </div>

      <div class="mt-3">
        <InputLabel for="password" value="Password" />

        <TextInput id="password" type="password" class="mt-2 form-control w-100" v-model="form.password" required
          autocomplete="current-password" />

        <InputError class="mt-2" :message="form.errors.password" />
      </div>

      <div class="mt-3 d-block">
        <label class="d-flex align-items-center">
          <Checkbox name="remember" v-model:checked="form.remember" />
          <span class="ms-2 small text-secondary">Remember me</span>
        </label>
      </div>

      <div class="mt-3 d-flex align-items-center justify-content-end">
        <Link v-if="canResetPassword" :href="route('password.request')"
          class="rounded text-decoration-underline small text-secondary hover-dark focus-outline-none">
        Forgot your password?
        </Link>

        <PrimaryButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
          Log in
        </PrimaryButton>
      </div>
    </form>
  </GuestLayout>
</template>
