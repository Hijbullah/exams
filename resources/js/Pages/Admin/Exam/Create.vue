<template>
    <admin-layout>  
        <div>
            <h2 class="text-xl text-gray-900 font-semibold border-b-2 border-gray-900">Create New Exam</h2>
            <div class="pt-5">
                <form @submit.prevent="createExam">
                    <div class="flex flex-col ">
                        <div class="w-full">
                            <jet-label for="name" value="Exam Name" />
                            <jet-input id="name" type="text" class="mt-2 block w-full" v-model="form.name" placeholder="Subject Name..." autocomplete="name" />
                            <jet-input-error :message="form.errors.name" class="mt-2" />
                        </div>
                        <div class="w-full mt-2 flex items-center space-x-3">
                            <div class="w-1/2">
                                <jet-label for="name" value="Batch" />
                                <jet-input id="name" type="text" class="mt-2 block w-full" v-model="form.name" placeholder="Subject Name..." autocomplete="name" />
                                <jet-input-error :message="form.errors.name" class="mt-2" />
                            </div>
                            <div class="w-1/2">
                                <jet-label for="name" value="Exam Type" />
                                <jet-input id="name" type="text" class="mt-2 block w-full" v-model="form.name" placeholder="Subject Name..." autocomplete="name" />
                                <jet-input-error :message="form.errors.name" class="mt-2" />
                            </div>
                        </div>
                        <div class="w-full mt-2 flex items-center space-x-3">
                            <div class="w-1/3">
                                <jet-label for="name" value="Total Question" />
                                <jet-input id="name" type="text" class="mt-2 block w-full" v-model="form.name" placeholder="Subject Name..." autocomplete="name" />
                                <jet-input-error :message="form.errors.name" class="mt-2" />
                            </div>
                            <div class="w-1/3">
                                <jet-label for="name" value="Pass Mark" />
                                <jet-input id="name" type="text" class="mt-2 block w-full" v-model="form.name" placeholder="Subject Name..." autocomplete="name" />
                                <jet-input-error :message="form.errors.name" class="mt-2" />
                            </div>
                            <div class="w-1/3">
                                <jet-label for="name" value="Exam Duration" />
                                <jet-input id="name" type="text" class="mt-2 block w-full" v-model="form.name" placeholder="Subject Name..." autocomplete="name" />
                                <jet-input-error :message="form.errors.name" class="mt-2" />
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p>Subject</p>
                        <div>
                            <jet-label for="terms">
                                <div class="flex items-center">
                                    <jet-checkbox name="terms" id="terms" v-model="form.name" />

                                    <div class="ml-2">
                                        I agree to the
                                    </div>
                                </div>
                            </jet-label>
                        </div>
                    </div>
                    <div class="mt-8">
                        <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Save
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

    export default {
        components: {
            AdminLayout,
            JetInput,
            JetInputError,
            JetLabel,
            JetCheckbox,
            JetButton,
            JetSecondaryButton
        },
        
        data() {
            return {
                form: this.$inertia.form({
                    name: ''
                })
            }
        },
        methods: {
            createExam(){
                 this.form.post(route('admin.subjects.store'), {
                    preserveScroll: true,
                });
            }, 
            goBack() {
                this.$inertia.visit(route('admin.subjects.index'));
            }
        }
    }
</script>