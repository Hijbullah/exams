<template>
    <admin-layout>
        <div>
            <h2 class="text-xl text-gray-900 font-semibold border-b-2 border-gray-900">All Subjects</h2>

            <div class="mt-5">
                <div class="mb-6 flex justify-between items-center">
                    <search-filter v-model="form.search" class="w-full max-w-lg mr-4" @reset="reset"></search-filter>
                    <div>
                        <inertia-link 
                            :href="route('admin.subjects.create')" 
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
                            <th class="px-6 pt-4 pb-4 font-normal text-center">Action</th>
                        </tr>

                        <tr v-for="subject in subjects.data" :key="subject.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                            <td class="border-t px-6 py-2">
                                {{ subject.name }}
                            </td>
                          
                            <td class="border-t px-6 py-2 text-center">
                                {{ subject.exams_count }}
                            </td>
                            
                            
                            <td class="border-t px-6 py-2 text-center space-x-2">
                                <show-button :href="route('admin.subjects.show', subject.id)" />
                                <edit-button :href="route('admin.subjects.edit', subject.id)" />
                                <delete-button :href="route('admin.subjects.destroy', subject.id)" />
                            </td>
                        </tr>
                        <tr v-if="subjects.data.length === 0">
                            <td class="border-t px-6 py-4" colspan="5">No subjects found.</td>
                        </tr>
                    
                    </table>
                </div>

                <pagination v-if="subjects.data.length" :links="subjects.links" />
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
            subjects: Object,
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
                    this.$inertia.replace(route('admin.subjects.index', Object.keys(query).length ? query : { remember: 'forget' }))
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