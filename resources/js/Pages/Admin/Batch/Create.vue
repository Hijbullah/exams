<template>
    <admin-layout>  
        <div>
            <h2 class="text-xl text-gray-900 font-semibold border-b-2 border-gray-900">Create New Batch</h2>
            <div class="pt-5">
                <form @submit.prevent="createBatch">
                    <div class="flex flex-col ">
                        <div class="w-full">
                            <jet-label for="name" value="Batch Name" />
                            <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" placeholder="Batch Name..." autocomplete="name" />
                            <jet-input-error :message="form.errors.name" class="mt-2" />
                        </div>
                        <div class="w-full mt-4 editor">
                            <jet-label for="detail" value="Details About Batch" />
                            <vue-editor 
                                class="mt-2 bg-white" 
                                v-model="form.detail" 
                                :editor-toolbar="customToolbar" 
                                placeholder="Details About Batch..."
                            />
                            <jet-input-error :message="form.errors.detail" class="mt-2" />
                        </div>
                    </div>
                    <div class="mt-4 text-right">
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
    import { VueEditor } from 'vue2-editor'
    import JetButton from '@/Jetstream/Button'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'

    export default {
        components: {
            AdminLayout,
            JetInput,
            JetInputError,
            JetLabel,
            VueEditor,
            JetButton,
            JetSecondaryButton
        },
        
        data() {
            return {
                form: this.$inertia.form({
                    name: '',
                    detail: '',
                }),
                customToolbar: [
                    [{ header: [false, 1, 2, 3, 4, 5, 6] }],

                    ["bold", "italic", "underline", "strike"],
                    [{ header: 1 }, { header: 2 }],
        
                    [
                        { align: "" },
                        { align: "center" },
                        { align: "right" },
                        { align: "justify" }
                    ],


                    ["blockquote", "code-block"],

                    [{ list: "ordered" }, { list: "bullet" }, { list: "check" }],

                    [{ indent: "-1" }, { indent: "+1" }],

                    [{ color: [] }, { background: [] }],

                    ["clean"]
                ]
            }
        },
        methods: {
            createBatch(){
                 this.form.post(route('admin.batches.store'), {
                    preserveScroll: true,
                });
            }, 
            goBack() {
                this.$inertia.visit(route('admin.batches.index'));
            }
        }
    }
</script>