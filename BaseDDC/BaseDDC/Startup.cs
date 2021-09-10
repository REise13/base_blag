using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Builder;
using Microsoft.AspNetCore.Hosting;
using Microsoft.AspNetCore.Mvc;
using Microsoft.Extensions.Configuration;
using Microsoft.Extensions.DependencyInjection;
using Microsoft.Extensions.Logging;
using Microsoft.Extensions.Options;
using AutoMapper;
using BaseDDC.model;
using BaseDTO;
namespace BaseDDC
{
    public class Startup
    {
        public Startup(IConfiguration configuration)
        {
            Mapper.Initialize(cfg =>
            {
                cfg.AllowNullCollections = true;
                cfg.CreateMap<DTO_People_Reg, People>();
                cfg.CreateMap< People,DTO_People_Reg > ();

                cfg.CreateMap<DTO_People_Get, People>();

                cfg.CreateMap<DTO_Profile_Get, model.Profile>();
                cfg.CreateMap<model.Profile, DTO_Profile_Get>();

                cfg.CreateMap<DTO_People_Update, model.People>();
                cfg.CreateMap<model.People, DTO_People_Update>();

                cfg.CreateMap<DTO_City, City>();
                cfg.CreateMap<DTO_Gender, Gender>();

                cfg.CreateMap<DTO_Help_Add, Help>();

                cfg.CreateMap<Help, DTO_Help_Get>();

                cfg.CreateMap<Project, DTO_Project_Get>();

                cfg.CreateMap<DTO_Project_Add, Project>();

                cfg.CreateMap<model.User, DTO_User_Get>();

                cfg.CreateMap<DTO_Lead_Reg, Lead>();

                cfg.CreateMap<Lead, DTO_Lead_Get>();
                cfg.CreateMap<DTO_Lead_Get, Lead>();

                cfg.CreateMap<DTO_User_Create, User>();

            });


                Configuration = configuration;
        }

        public IConfiguration Configuration { get; }

        // This method gets called by the runtime. Use this method to add services to the container.
        public void ConfigureServices(IServiceCollection services)
        {
            services.AddMvc().SetCompatibilityVersion(CompatibilityVersion.Version_2_1);
        }

        // This method gets called by the runtime. Use this method to configure the HTTP request pipeline.
        public void Configure(IApplicationBuilder app, IHostingEnvironment env)
        {
            if (env.IsDevelopment())
            {
                app.UseDeveloperExceptionPage();
            }

            app.UseMvc();
        }
    }
}
