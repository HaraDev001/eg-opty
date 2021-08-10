<template>
  <div class="text-center">
    <v-dialog
      v-model="show"
    >
      <v-card>
        <v-card-title
          class="headline d-flex justify-space-between"
          primary-title
        >
          <v-btn-toggle tile group>
            <v-btn value="0" @click="">Today</v-btn>
            <v-btn value="1" @click="$refs.calendar.next()">Back</v-btn>
            <v-btn value="2" @click="$refs.calendar.prev()">Next</v-btn>
          </v-btn-toggle>
          <label>
            {{title}}
          </label>
          <v-btn-toggle tile group v-model="calendar_type">
            <v-btn value="month">Month</v-btn>
            <v-btn value="week">Week</v-btn>
            <v-btn value="day">Day</v-btn>
            <v-btn value="agenda" disabled>Agenda</v-btn>
          </v-btn-toggle>
        </v-card-title>

        <v-card-text>
          <template>
            <div>
              <v-sheet height="600">
                <v-calendar
                  ref="calendar"
                  v-model="value"
                  :weekdays="weekday"
                  :type="calendar_type"
                  :events="events"
                  :event-overlap-mode="mode"
                  :event-overlap-threshold="30"
                  :event-color="getEventColor"
                  @change="getEvents"
                />
              </v-sheet>
            </div>
          </template>

        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
  export default {
    props: {
      show: {type:Boolean, default: false},
    },
    data: () => ({
      title: '',
      calendar_type: 'month',
      types: ['month', 'week', 'day', '4day'],
      mode: 'stack',
      weekday: [0, 1, 2, 3, 4, 5, 6],
      value: '',
      events: [],
      colors: ['blue', 'indigo', 'deep-purple', 'cyan', 'green', 'orange', 'grey darken-1'],
      names: ['Meeting', 'Holiday', 'PTO', 'Travel', 'Event', 'Birthday', 'Conference', 'Party'],
    }),
    methods: {
      getEvents ({ start, end }) {
        const events = []

        const min = new Date(`${start.date}T00:00:00`)
        const max = new Date(`${end.date}T23:59:59`)
        const days = (max.getTime() - min.getTime()) / 86400000
        const eventCount = this.rnd(days, days + 20)

        for (let i = 0; i < eventCount; i++) {
          const allDay = this.rnd(0, 3) === 0
          const firstTimestamp = this.rnd(min.getTime(), max.getTime())
          const first = new Date(firstTimestamp - (firstTimestamp % 900000))
          const secondTimestamp = this.rnd(2, allDay ? 288 : 8) * 900000
          const second = new Date(first.getTime() + secondTimestamp)

          events.push({
            name: this.names[this.rnd(0, this.names.length - 1)],
            start: this.formatDate(first, !allDay),
            end: this.formatDate(second, !allDay),
            color: this.colors[this.rnd(0, this.colors.length - 1)],
          })
        }

        this.events = events
      },
      getEventColor (event) {
        return event.color
      },
      rnd (a, b) {
        return Math.floor((b - a + 1) * Math.random()) + a
      },
      formatDate (a, withTime) {
        return withTime
          ? `${a.getFullYear()}-${a.getMonth() + 1}-${a.getDate()} ${a.getHours()}:${a.getMinutes()}`
          : `${a.getFullYear()}-${a.getMonth() + 1}-${a.getDate()}`
      },
    },
  }
</script>

<style scoped>

</style>