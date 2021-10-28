<template>
    <default-field :field="field" :errors="errors" :show-help-text="showHelpText">
        <template slot="field">
            <div class="relative">
                <div ref="suggestionList" class="flex suggestions-list mb-3">
                    <div
                        class="pr-3 w-1/2"
                        @drop='onDrop'
                        @dragover.prevent
                        @dragenter.prevent
                    >
                        <div
                            v-for="(item, index) in value"
                            :key="index"
                            class="flex border border-40 bg-30 p-2 mb-3 text-sm items-center justify-between"
                        >
                            {{ item }}
                            <button @click.prevent="deleteItem(index)">
                                <close-icon/>
                            </button>
                        </div>
                    </div>

                    <div class="pl-3 w-1/2 relative">
                        <div
                            v-for="(suggestion, index) in suggestions"
                            :key="index"
                            class="cursor-pointer flex border border-40 bg-30 p-2 mb-3 text-sm items-center"
                            draggable
                            @dragstart='startDrag($event, index)'
                        >
                            <button @click.prevent="addSuggestionToItems(index)">
                                <arrow-icon/>
                            </button>
                            <span class="ml-2">{{ suggestion }}</span>
                        </div>
                    </div>
                </div>

                <button
                    v-if="showRefreshButton"
                    class="absolute btn-refresh text-sm ml-3"
                    @click.prevent="fetchSuggestions"
                >
                    <refresh-icon/>
                </button>
            </div>
            <input
                :id="field.name"
                type="text"
                class="w-full form-control form-input form-input-bordered"
                :class="errorClasses"
                :placeholder="field.name"
                v-model.trim="newItem"
                @keydown.enter.prevent="addItem"
            />
        </template>
    </default-field>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'

import CloseIcon from '../icons/Close'
import ArrowIcon from '../icons/Arrow'
import RefreshIcon from '../icons/Refresh'

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ['resourceName', 'resourceId', 'field'],

    components: {
        CloseIcon,
        ArrowIcon,
        RefreshIcon
    },

    data: () => ({
        newItem: '',
        suggestions: []
    }),

    computed: {
        isAutoRefreshEnabled () {
            return !!this.field.autorefresh
        },
        showRefreshButton () {
            return this.value
                && this.value.length > 0
                && !this.isAutoRefreshEnabled
        }
    },

    watch: {
        value () {
            if (this.isAutoRefreshEnabled) {
                this.fetchSuggestions()
            }
            this.$nextTick(() => this.scrollToBottom())
        }
    },

    methods: {
        /*
         * Set the initial, internal value for the field.
         */
        setInitialValue () {
            this.value = this.field.value || []
            this.fetchSuggestions()
        },

        /**
         * Fill the given FormData object with the field's internal value.
         */
        fill (formData) {
            const value = this.value ? JSON.stringify(this.value) : []
            formData.append(this.field.attribute, value)
        },

        addItem () {
            if (this.newItem) {
                this.value.push(this.newItem)
                this.newItem = ''
            }
        },

        addSuggestionToItems (index) {
            const suggestion = this.suggestions[index]
            this.value.push(suggestion)
            this.suggestions.splice(index, 1)
        },

        deleteItem (index) {
            this.value.splice(index, 1)
        },

        scrollToBottom () {
            this.$refs.suggestionList.scrollTop = this.$refs.suggestionList.scrollHeight
        },

        startDrag (event, suggestionIndex) {
            event.dataTransfer.dropEffect = 'move'
            event.dataTransfer.effectAllowed = 'move'
            event.dataTransfer.setData('suggestionIndex', suggestionIndex)
        },

        onDrop (event) {
            const index = event.dataTransfer.getData('suggestionIndex')
            this.addSuggestionToItems(index)
        },

        fetchSuggestions () {
            Nova.request()
                .post('/nova-vendor/suggestion-list/suggestions', {
                    value: this.value,
                    options: this.field.suggesterOptions
                })
                .then(({ data }) => (this.suggestions = data.suggestions))
        }
    },
}
</script>
