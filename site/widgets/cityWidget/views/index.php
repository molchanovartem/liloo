<div id="cities" class="uk-position-relative" style="display: none" :style="{display: show ? 'block' : 'none'}">
    <div>
        <button class="uk-button uk-button-link" @click="onToggle">{{cmdCityName}}</button>
        <div class="uk-drop" :class="{'uk-open': open}" style="width: 400px;">
            <div class="uk-drop-grid uk-child-width-1-1">
                <div class="uk-card uk-card-default uk-position-relative uk-padding">
                    <button @click="onToggle" class="uk-position-top-right">
                        <i class="mdi mdi-close uk-text-large uk-margin-small-right"></i>
                    </button>
                    <div class="uk-grid uk-grid-small uk-flex-bottom">
                        <div class="uk-width-expand">
                            <v-autocomplete
                                    v-model="city"
                                    :items="cities"
                                    item-value="id"
                                    item-text="name"
                                    hide-details
                                    append-icon="mdi-chevron-down"
                                    label="Город"
                                    @change="onChangeCityId"
                            />
                        </div>
                        <div class="uk-width-auto">
                            <button @click="onToggle" class="uk-button uk-button-default">Ok</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
