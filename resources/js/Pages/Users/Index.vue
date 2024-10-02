<script setup>
import { ref, watch } from "vue";
import Pagination from "../../Shared/Pagination.vue";
import { router } from "@inertiajs/vue3";
import debounce from "lodash/debounce";

// import Layout from "../Shared/Layout.vue";

// defineOptions({ layout: Layout });

// import { Link } from "@inertiajs/vue3";

let props = defineProps({
    time: String,
    users: Object,
    filters: Object,
    can: Object,
});

let search = ref(props.filters.search);

watch(
    search,
    debounce(function (value) {
        router.get(
            "/users",
            { search: value },
            { preserveState: true, replace: true }
        );
    }, 500)
);

/* watch(search, (value) => {
    router.get(
        "/users",
        { search: value },
        { preserveState: true, replace: true }
    );
}); */

function del(id) {
    router.delete("/users/" + id);
}
</script>

<template>
    <Head title="Users" />

    <div class="flex justify-between mb-6">
        <div class="flex items-center">
            <h1 class="text-3xl">Users</h1>

            <Link
                v-if="can.createUser"
                href="/users/create"
                class="text-blue-500 text-sm ml-2"
            >
                New User
            </Link>
        </div>
        <input
            v-model="search"
            type="text"
            placeholder="Search..."
            class="border px-2 rounded-lg"
        />
    </div>

    <ul role="list" class="divide-y divide-gray-100">
        <li
            v-for="user in users.data"
            :key="user.id"
            class="flex justify-between gap-x-6 py-5"
        >
            <div class="flex min-w-0 gap-x-4">
                <div class="min-w-0 flex-auto">
                    <p class="text-sm font-semibold leading-6 text-gray-900">
                        {{ user.name }}
                    </p>
                    <!-- <p class="mt-1 truncate text-xs leading-5 text-gray-500">
                        leslie.alexander@example.com
                    </p> -->
                </div>
            </div>

            <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                <Link :href="`/users/${user.id}/edit`"> Edit </Link>
            </div>

            <button @click="del(user.id)">Delete</button>
        </li>
    </ul>

    <Pagination :links="users.links" class="mt-6" />

    <div style="margin-top: 400px">
        <p>The current time is {{ time }}.</p>
        <Link href="/users" class="text-blue-500" preserve-scroll>
            Refresh
        </Link>
    </div>
</template>
