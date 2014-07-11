from django.shortcuts import render, render_to_response, redirect
from django.http import HttpResponse, HttpResponseRedirect
from django.template import RequestContext
from django.contrib.auth.decorators import login_required
from django.contrib.auth.views import login
from django.contrib.auth.models import User
from django.contrib.auth import authenticate, logout
from django.forms.formsets import formset_factory

from xdashboard.models import School, Event, EventTeam, Member, Product, Genius
from xdashboard.forms import EventTeamForm, BaseEventTeamFormSet, ProductForm

# Create your views here.


# Dashboard login

def user_login(request):
    return login(request, template_name = 'xdashboard/index.html')

# Registration for the day

@login_required(login_url = '/xdashboard/login/')
def register(request):
    
    context = RequestContext(request)
    currSchool = School.objects.get(user = request.user)
    eventTuple = Event.EVENTS
    noOfEvents = len(eventTuple)
    EventTeamFormSet = formset_factory(EventTeamForm, extra = noOfEvents, formset=BaseEventTeamFormSet)

    if request.method == 'POST':
	formset = EventTeamFormSet(request.POST)

	if formset.is_valid():	
	    i = 0
	    for form in formset:
		participating = form.cleaned_data['event']

		if participating == True:

    		    event = Event.objects.get(pk = i+1)

		    mem1 = form.cleaned_data['mem1']
		    mem1 = Member(name = mem1)
		    mem1.save()
		    mem2 = form.cleaned_data['mem2']
		    mem2 = Member(name = mem2)
		    mem2.save()

		    if event == "Quiz":
		        mem3 = form.cleaned_data['mem3']
		        mem3 = Member(name = mem3)
			mem3.save()
		
		    # creating database queries, many mistakes!

		    team = EventTeam(school = currSchool, event = event)
		    team.save()
		    mem1.events.add(team)
		    mem2.events.add(team)
		    try:
		        mem3.events.add(team)
		    except NameError:
			pass

		    i += 1

		    return HttpResponse("Done")

	    else:
		print formset.errors

    else:
	formset = EventTeamFormSet()

    context_dict = {
	'formset': formset,
    }

    return render_to_response('xdashboard/register.html', context_dict, context)

'''
def home(request):

    context = RequestContext(request)
    currSchool = School.objects.get(user = request.user) 


def leaderboard(request):

    context = RequestContext(request)
    currSchool = School.objects.get(user = request.user) 


'''

