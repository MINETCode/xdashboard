from django.contrib import admin
from django.contrib.auth.admin import User, UserAdmin
from xdashboard.models import School, Event, EventTeam, Member, Product, Genius

class SchoolInline(admin.StackedInline):
    model = School
    can_delete = False
    verbose_name_plural = 'school'

class UserAdmin(UserAdmin):
    inlines = (SchoolInline, )

# Register your models here.

admin.site.unregister(User)
admin.site.register(User, UserAdmin)
admin.site.register(School)
admin.site.register(Event)
admin.site.register(EventTeam)
admin.site.register(Member)
admin.site.register(Product)
admin.site.register(Genius)
