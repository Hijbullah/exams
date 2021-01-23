<template>
    <admin-layout>
        <div>
            <h2 class="text-xl text-gray-900 font-semibold border-b-2 border-gray-900">All Batch</h2>

            <div class="mt-5">
                <div class="mb-6 flex justify-between items-center">
                    <search-filter v-model="form.search" class="w-full max-w-lg mr-4" @reset="reset"></search-filter>
                    <div>
                        <inertia-link 
                            :href="route('admin.batches.create')" 
                            class="btn-main px-3 py-2 text-sm font-semibold uppercase tracking-widest"
                        >
                            Create
                        </inertia-link>
                    </div>
                </div>

                <div class="bg-white rounded shadow overflow-x-auto">
                    <table class="w-full whitespace-no-wrap">
                        <tr class="text-left">
                            <th class="px-6 pt-4 pb-4 font-normal">Name</th>
                            <th class="px-6 pt-4 pb-4 font-normal text-center">Exam (s)</th>
                            <th class="px-6 pt-4 pb-4 font-normal text-center">Student (s)</th>
                            
                            <th class="px-6 pt-4 pb-4 font-normal text-center">Action</th>
                        </tr>

                        <tr v-for="batch in batches.data" :key="batch.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                            <td class="border-t px-6 py-2">
                                {{ batch.name }}
                            </td>
                            <td class="border-t px-6 py-2 text-center">
                                {{ batch.exams_count }}
                            </td>
                            <td class="border-t px-6 py-2 text-center">
                                {{ batch.students_count }}
                            </td>
                            
                            <td class="border-t px-6 py-2 text-center space-x-2">
                                <show-button :href="route('admin.batches.show', batch.slug)" />
                                <edit-button :href="route('admin.batches.edit', batch.slug)" />
                                <delete-button :href="route('admin.batches.destroy', batch.slug)" />
                            </td>
                        </tr>
                        <tr v-if="batches.data.length === 0">
                            <td class="border-t px-6 py-4" colspan="5">No batches found.</td>
                        </tr>
                    
                    </table>
                </div>

                <pagination v-if="batches.data.length" :links="batches.links" />
            </div>
        </div>
    </admin-layout>
</template>

<script>
    import AdminLayout from '@/Layouts/AdminLayout'
    import ShowButton from '@/Component/Admin/ActionButton/Show'
    import EditButton from '@/Component/Admin/ActionButton/Edit'
    import DeleteButton from '@/Component/Admin/ActionButton/Delete'
    import Pagination from '@/Component/Admin/Pagination'
    import SearchFilter from '@/Component/Admin/SearchFilter'

    export default {
        components: {
            AdminLayout,
            ShowButton,
            EditButton,
            DeleteButton,
            Pagination,
            SearchFilter
        },
        props: {
            batches: Object,
            filters: Object
        },
        data() {
            return {
                form: {
                    search: this.filters.search,
                }
            }
        },
        watch: {
            form: {
                handler: _.throttle(function() {
                    let query = _.pickBy(this.form);
                    this.$inertia.replace(route('admin.batches.index', Object.keys(query).length ? query : { remember: 'forget' }))
                }, 150),
                deep: true,
            },
        },
        methods: {
            reset() {
                this.form = _.mapValues(this.form, () => null)
            },
        }
    }
</script>