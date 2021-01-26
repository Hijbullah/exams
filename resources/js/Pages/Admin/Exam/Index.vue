<template>
    <admin-layout>
        <div>
            <h2 class="text-xl text-gray-900 font-semibold border-b-2 border-gray-900">All Exams</h2>

            <div class="mt-5">
                <div class="mb-6 flex justify-between items-center">
                    <search-filter v-model="form.search" class="w-full max-w-lg mr-4" @reset="reset"></search-filter>
                    <div>
                        <inertia-link 
                            :href="route('admin.exams.create')" 
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
                            <th class="px-6 pt-4 pb-4 font-normal">Batch</th>
                            <th class="px-6 pt-4 pb-4 font-normal">Questions</th>
                            <th class="px-6 pt-4 pb-4 font-normal">Exam Date</th>
                            <th class="px-6 pt-4 pb-4 font-normal">Status</th>
                            <th class="px-6 pt-4 pb-4 font-normal text-center">Action</th>
                        </tr>

                        <tr v-for="exam in exams.data" :key="exam.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                            <td class="border-t px-6 py-2">
                                {{ exam.name }}
                            </td>
                          
                            <td class="border-t px-6 py-2 text-center">
                                {{ exam.batch.name }}
                            </td>

                            <td class="border-t px-6 py-2 text-center">
                               {{ '0' }} / {{ exam.total_question }}
                            </td>
                            <td class="border-t px-6 py-2 text-center">
                                <span class="block">{{ exam.exam_schedule.start }}</span>
                                <span class="block"> to </span>
                                <span class="block">{{ exam.exam_schedule.end }}</span>
                            </td>
                            <td class="border-t px-6 py-2 text-center">
                                {{ exam.exam_status }}
                            </td>
                            
                            
                            <td class="border-t px-6 py-2 text-center space-x-2">
                                <inertia-link
                                    :href="route('admin.exams.show', exam.id)" 
                                    class="btn-main px-2 py-1 text-xs uppercase font-medium tracking-wider"
                                >
                                    Dashboard
                                </inertia-link>
                                <!-- <show-button :href="route('admin.exams.show', exam.id)" />
                                <edit-button :href="route('admin.exams.edit', exam.id)" />
                                <delete-button :href="route('admin.exams.destroy', exam.id)" /> -->
                            </td>
                        </tr>
                        <tr v-if="exams.data.length === 0">
                            <td class="border-t px-6 py-4" colspan="5">No exams found.</td>
                        </tr>
                    
                    </table>
                </div>

                <pagination v-if="exams.data.length" :links="exams.links" />
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
            exams: Object,
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
                    this.$inertia.replace(route('admin.exams.index', Object.keys(query).length ? query : { remember: 'forget' }))
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