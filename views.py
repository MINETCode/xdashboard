from django.shortcuts import render, render_to_response, redirect
from django.http import HttpResponse, HttpResponseRedirect
from django.template import RequestContext
from django.contrib.auth.decorators import login_required
from django.contrib.auth.views import login
from django.contrib.auth.models import User
from django.contrib.auth import authenticate, logout
from django.forms.formsets import formset_factory

import random

from xdashboard.models import School, Event, EventTeam, Member, Product, Genius
from xdashboard.forms import EventTeamForm, BaseEventTeamFormSet, ProductForm, ProductAcqForm

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
	'currSchool': currSchool,
    }

    return render_to_response('xdashboard/register.html', context_dict, context)


@login_required(login_url = '/xdashboard/login/')
def home(request):

    context = RequestContext(request)
    currSchool = School.objects.get(user = request.user) 

    if request.method == 'POST':
	request_genius(currSchool)

    try:
        genList = Genius.objects.filter(school = currSchool.name)
    except:
	genList = Genius.objects.none()

    context_dict = {
	'currSchool': currSchool,
	'genList': genList,
    }
 
    return render_to_response('xdashboard/home.html', context_dict, context)

def request_genius(currSchool):

    try:    
        genList = Genius.objects.filter(active = False)
        nameList = []
        for gen in genList:
	    nameList.append(gen.name)
        genName = random.choice(nameList)
        genius = Genius.objects.get(name = genName)
        genius.school = currSchool.name
        genius.active = True
        genius.save(update_fields = ['school'])
        genius.save(update_fields = ['active'])
	salary = 2000                   # change this depending on salary of genius
	currSchool.currCap -= salary
    except IndexError:
	pass


@login_required(login_url = '/xdashboard/login/')
def products(request):

    context = RequestContext(request)
    currSchool = School.objects.get(user = request.user) 
    prodList = Product.objects.filter(upForAcq = True).order_by('school')
    ownProdList = Product.objects.filter(school = currSchool)
    noOfProducts = len(prodList)
    ProductAcqFormSet = formset_factory(ProductAcqForm, extra = noOfProducts)

    if request.method == 'POST':

	if request.POST['action'] == 'product_create':
            prod_form = ProductForm(request.POST)    
	    formset = ProductAcqFormSet()
	    if prod_form.is_valid():
	        product = prod_form.save(commit=False)
	        product.school = currSchool
	        prod_form.save()
	    else:
	        print prod_form.errors

	elif request.POST['action'] == 'product_acq':
            formset = ProductAcqFormSet(request.POST, request.FILES) 
	    prod_form = ProductForm()   
	    if formset.is_valid():            
	        i = 0
	        for form in formset:
		    acq = form.cleaned_data['acq']
		    if acq == True:
            	        product = prodList[i]
		        product.isAcq = True
		        product.acqSchool = currSchool.name
		        product.upForAcq = False
		        product.save(update_fields = ['isAcq'])
		        product.save(update_fields = ['acqSchool'])
		        product.save(update_fields = ['upForAcq'])
		        cost = product.cost
		        currSchool.currCap -= cost
		        product.school.currCap += cost

    else:
	prod_form = ProductForm()    
	formset = ProductAcqFormSet()

    context_dict = {
	'currSchool': currSchool,
	'prodList': prodList,
	'ownProdList': ownProdList,
	'formset': formset,
	'prod_form': prod_form,
    }

    return render_to_response('xdashboard/products.html', context_dict, context)

"""
@login_required(login_url = '/xdashboard/login/')
def leaderboards(request):
    context = RequestContext(request)
    currSchool = School.objects.get(user = request.user) 
    return render_to_response('xdashboard/leaderboards.html', context)
"""
