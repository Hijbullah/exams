<template>
    <admin-layout>  
        <div>
            <h2 class="text-xl text-gray-900 font-semibold border-b-2 border-gray-900">Create New Exam</h2>
            <div class="pt-5">
                <form @submit.prevent="editExam">
                    <div class="flex flex-col">
                        <div class="w-full flex items-center space-x-3">
                            <div class="w-1/2">
                                <jet-label for="batch" value="Batch" />
                                <input-select v-model="form.batch" id="batch" class="mt-2 w-full">
                                    <option disabled :value="null">Select A Batch</option>
                                    <option :value="batch.id" v-for="batch in batches" :key="batch.id">{{ batch.name }}</option>
                                </input-select>   
                                <jet-input-error :message="form.errors.batch" class="mt-2" />
                            </div>
                            <div class="w-1/2">
                                <jet-label for="exam_type" value="Exam Type" />
                                <input-select v-model="form.exam_type" id="exam_type" class="mt-2 w-full">
                                    <option disabled :value="null">Select A Exam Type</option>
                                    <option :value="examType.id" v-for="examType in examTypes" :key="examType.id">{{ examType.name }}</option>
                                </input-select>   
                                <jet-input-error :message="form.errors.exam_type" class="mt-2" />
                            </div>
                        </div>
                        <div class="w-full mt-2">
                            <jet-label for="name" value="Exam Name" />
                            <jet-input id="name" type="text" class="mt-2 block w-full" v-model="form.name" placeholder="Exam Name..." autocomplete="name" />
                            <jet-input-error :message="form.errors.name" class="mt-2" />
                        </div>
                        <div class="w-full mt-2 flex items-center space-x-3">
                            <div class="w-1/3">
                                <jet-label for="total_question" value="Total Question" />
                                <jet-input id="total_question" type="number" min="0" class="mt-2 block w-full" v-model="form.total_question" placeholder="Total Question..." />
                                <jet-input-error :message="form.errors.total_question" class="mt-2" />
                            </div>
                            <div class="w-1/3">
                                <jet-label for="pass_mark" value="Pass Mark" />
                                <jet-input id="pass_mark" type="text" class="mt-2 block w-full" v-model="form.pass_mark" placeholder="Pass Mark..." />
                                <jet-input-error :message="form.errors.pass_mark" class="mt-2" />
                            </div>
                            <div class="w-1/3">
                                <jet-label for="exam_duration" value="Exam Duration" />
                                <jet-input id="exam_duration" type="text" class="mt-2 block w-full" v-model="form.exam_duration" placeholder="Exam Duration..." />
                                <jet-input-error :message="form.errors.exam_duration" class="mt-2" />
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 flex space-x-8">
                         <div class="w-1/2">
                            <p class="font-medium text-gray-700">Select Subjects</p>
                            <div class="mt-3 w-full h-64 space-y-3 overflow-y-auto">
                                <div v-for="subject in subjects" :key="subject.id">
                                    <jet-label :for="'subject_' + subject.id" class="inline-flex items-center cursor-pointer">
                                        <div class="flex items-center">
                                            <jet-checkbox :id="'subject_' + subject.id" :value="subject.name" v-model="form.subjects" class="cursor-pointer" />

                                            <div class="ml-2 text-base font-normal select-none">
                                                {{ subject.name }}
                                            </div>
                                        </div>
                                    </jet-label>
                                </div>
                            </div>
                            <jet-input-error :message="form.errors.subjects" class="mt-2" />
                        </div>

                        <div class="w-1/2">
                            <div>
                                <p class="font-medium text-gray-700">Negetive Mark</p>
                                <div class="mt-3 flex space-x-3 items-center">
                                    <div>
                                        <jet-label for="negative_mark_status" class="inline-flex items-center cursor-pointer">
                                            <div class="flex items-center">
                                                <jet-checkbox name="subjects" id="negative_mark_status" v-model="hasNegativeMark" class="cursor-pointer" />

                                                <div class="ml-2 text-base font-normal select-none">
                                                    Has Negative Mark
                                                </div>
                                            </div>
                                        </jet-label>
                                    </div>
                                    <div v-if="hasNegativeMark" class="w-1/3">
                                        <jet-input type="number" min="0" step="0.01" class="block w-full" v-model="negativeMark" placeholder="Negative Mark..." autocomplete="name" />
                                        <jet-input-error :message="form.errors.negative_mark" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <jet-label for="exam_start_at" value="Exam Started At" />
                                <datetime
                                    id="exam_start_at"
                                    type="datetime"
                                    v-model="form.exam_start_at"
                                    :week-start="6"
                                    value-zone="Asia/Dhaka"
                                    input-class="mt-2 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    use12-hour
                                    auto
                                ></datetime>

                                <jet-input-error :message="form.errors.exam_start_at" class="mt-2" />
                            </div>
                            <div class="mt-3">
                                <jet-label for="exam_end_at" value="Exam Ended At" />

                                <datetime
                                    type="datetime"
                                    v-model="form.exam_end_at"
                                    :week-start="6"
                                    value-zone="Asia/Dhaka"
                                    input-class="mt-2 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    use12-hour
                                    auto
                                ></datetime>
                                <jet-input-error :message="form.errors.exam_end_at" class="mt-2" />

                            </div>
                        </div>
                    </div>
                    <div class="mt-8">
                        <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Update
                        </jet-button>
                        <jet-secondary-button @click.native.prevent="goBack">
                            Back
                        </jet-secondary-button>
                    </div>
                </form>
            </div>
        </div>
       
    </admin-layout>
</template>

<script>
    import AdminLayout from '@/Layouts/AdminLayout'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'
    import JetCheckbox from '@/Jetstream/Checkbox'
    import JetButton from '@/Jetstream/Button'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import InputSelect from '@/Component/Admin/Select'
    import { Datetime } from 'vue-datetime'
    import 'vue-datetime/dist/vue-datetime.css'

    export default {
        components: {
            AdminLayout,
            JetInput,
            JetInputError,
            JetLabel,
            JetCheckbox,
            JetButton,
            JetSecondaryButton,
            InputSelect,
            Datetime
        },

        props: {
            batches: Array,
            examTypes: Array,
            subjects: Array,
            exam: Object,
        },
        
        data() {
            return {
                hasNegativeMark: this.exam.has_negative_mark,
                negativeMark: this.exam.negative_mark,

                form: this.$inertia.form({
                    name: this.exam.name,
                    batch: this.exam.batch_id,
                    exam_type: this.exam.exam_type_id,
                    total_question: this.exam.total_question,
                    pass_mark: this.exam.pass_mark,
                    exam_duration: this.exam.exam_duration,
                    exam_start_at: this.exam.exam_started_at,
                    exam_end_at: this.exam.exam_ended_at,
                    subjects: this.exam.subjects,
                    has_negative_mark: this.exam.has_negative_mark,
                    negative_mark: this.exam.negative_mark
                }),

            }
        },
        methods: {
            editExam(){
                if(this.hasNegativeMark) {
                    this.form.has_negative_mark = true;
                    this.form.negative_mark= this.negativeMark;
                }
                
                this.form.put(route('admin.exams.update', this.exam.id), {
                    preserveScroll: true,
                });
            }, 
            goBack() {
                this.$inertia.visit(route('admin.exams.show', this.exam.id));
            }
        },
        watch: {
            hasNegativeMark() {
                if(!this.hasNegativeMark) {
                    this.form.has_negative_mark = false;
                    this.form.negative_mark = null;
                    this.negativeMark = this.exam.negative_mark;
                }
            }
        }
    }
</script>