from django.conf.urls import patterns, url

from xdashboard import views

urlpatterns = patterns('',
    url(r'^login/$', views.user_login, name='login'),
    url(r'^register/$', views.register, name='register'),
)
