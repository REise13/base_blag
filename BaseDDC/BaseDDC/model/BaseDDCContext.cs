using System;
using Microsoft.EntityFrameworkCore;
using Microsoft.EntityFrameworkCore.Metadata;

namespace BaseDDC.model
{
    public partial class baseddcContext : DbContext
    {
        public baseddcContext()
        {
        }

        public baseddcContext(DbContextOptions<baseddcContext> options)
            : base(options)
        {
        }

        public virtual DbSet<Category> Category { get; set; }
        public virtual DbSet<City> City { get; set; }
        public virtual DbSet<Crosscategory> Crosscategory { get; set; }
        public virtual DbSet<Crossneed> Crossneed { get; set; }
        public virtual DbSet<Crosstraining> Crosstraining { get; set; }
        public virtual DbSet<Donor> Donor { get; set; }
        public virtual DbSet<Family> Family { get; set; }
        public virtual DbSet<Gender> Gender { get; set; }
        public virtual DbSet<HeatingType> HeatingType { get; set; }
        public virtual DbSet<Help> Help { get; set; }
        public virtual DbSet<Helptype> Helptype { get; set; }
        public virtual DbSet<Lead> Lead { get; set; }
        public virtual DbSet<LeadBdisctrict> LeadBdisctrict { get; set; }
        public virtual DbSet<LeadChildrens> LeadChildrens { get; set; }
        public virtual DbSet<LeadFamily> LeadFamily { get; set; }
        public virtual DbSet<LeadFamUnemp> LeadFamUnemp { get; set; }
        public virtual DbSet<LeadMigrant> LeadMigrant { get; set; }
        public virtual DbSet<LeadReason> LeadReason { get; set; }
        public virtual DbSet<Need> Need { get; set; }
        public virtual DbSet<People> People { get; set; }
        public virtual DbSet<Profile> Profile { get; set; }
        public virtual DbSet<Project> Project { get; set; }
        public virtual DbSet<Training> Training { get; set; }
        public virtual DbSet<TypeOfHouse> TypeOfHouse { get; set; }
        public virtual DbSet<User> User { get; set; }
        public virtual DbSet<UserRole> UserRole { get; set; }

        protected override void OnConfiguring(DbContextOptionsBuilder optionsBuilder)
        {
            if (!optionsBuilder.IsConfigured)
            {
#warning To protect potentially sensitive information in your connection string, you should move it out of source code. See http://go.microsoft.com/fwlink/?LinkId=723263 for guidance on storing connection strings.
                optionsBuilder.UseMySql("server=localhost;port=3306;user=root;password=YpUVMwmR8;database=baseddc");
            }
        }

        protected override void OnModelCreating(ModelBuilder modelBuilder)
        {
            modelBuilder.Entity<Category>(entity =>
            {
                entity.ToTable("category");

                entity.Property(e => e.Id)
                    .HasColumnName("id")
                    .HasColumnType("int(11)");

                entity.Property(e => e.Title)
                    .IsRequired()
                    .HasColumnName("title")
                    .HasColumnType("varchar(255)");
            });

            modelBuilder.Entity<City>(entity =>
            {
                entity.ToTable("city");

                entity.Property(e => e.Id)
                    .HasColumnName("id")
                    .HasColumnType("int(11)");

                entity.Property(e => e.Republic)
                    .HasColumnName("republic")
                    .HasColumnType("tinyint(4)");

                entity.Property(e => e.Title)
                    .IsRequired()
                    .HasColumnName("title")
                    .HasColumnType("varchar(225)");
            });

            modelBuilder.Entity<Crosscategory>(entity =>
            {
                entity.ToTable("crosscategory");

                entity.HasIndex(e => e.IdCategory)
                    .HasName("crosscategory_ibfk_1");

                entity.HasIndex(e => e.IdProfile)
                    .HasName("crosscategory_ibfk_2");

                entity.Property(e => e.Id)
                    .HasColumnName("id")
                    .HasColumnType("int(11)");

                entity.Property(e => e.IdCategory)
                    .HasColumnName("id_Category")
                    .HasColumnType("int(11)");

                entity.Property(e => e.IdProfile)
                    .HasColumnName("id_Profile")
                    .HasColumnType("int(11)");

                entity.HasOne(d => d.IdCategoryNavigation)
                    .WithMany(p => p.Crosscategory)
                    .HasForeignKey(d => d.IdCategory)
                    .HasConstraintName("crosscategory_ibfk_1");

                entity.HasOne(d => d.IdProfileNavigation)
                    .WithMany(p => p.Crosscategory)
                    .HasForeignKey(d => d.IdProfile)
                    .HasConstraintName("crosscategory_ibfk_2");
            });

            modelBuilder.Entity<Crossneed>(entity =>
            {
                entity.ToTable("crossneed");

                entity.HasIndex(e => e.IdNeed)
                    .HasName("id_needs_idx");

                entity.HasIndex(e => e.IdProfile)
                    .HasName("id_profile_idx");

                entity.Property(e => e.Id)
                    .HasColumnName("id")
                    .HasColumnType("int(11)");

                entity.Property(e => e.IdNeed)
                    .HasColumnName("id_Need")
                    .HasColumnType("int(11)");

                entity.Property(e => e.IdProfile)
                    .HasColumnName("id_Profile")
                    .HasColumnType("int(11)");

                entity.HasOne(d => d.IdNeedNavigation)
                    .WithMany(p => p.Crossneed)
                    .HasForeignKey(d => d.IdNeed)
                    .HasConstraintName("crossneed_ibfk_1");

                entity.HasOne(d => d.IdProfileNavigation)
                    .WithMany(p => p.Crossneed)
                    .HasForeignKey(d => d.IdProfile)
                    .HasConstraintName("crossneed_ibfk_2");
            });

            modelBuilder.Entity<Crosstraining>(entity =>
            {
                entity.ToTable("crosstraining");

                entity.HasIndex(e => e.IdProfile)
                    .HasName("id_profile_idx");

                entity.HasIndex(e => e.IdTraining)
                    .HasName("id_trainings_idx");

                entity.Property(e => e.Id)
                    .HasColumnName("id")
                    .HasColumnType("int(11)");

                entity.Property(e => e.DateTraining)
                    .HasColumnName("date_training")
                    .HasColumnType("date");

                entity.Property(e => e.IdProfile)
                    .HasColumnName("id_Profile")
                    .HasColumnType("int(11)");

                entity.Property(e => e.IdTraining)
                    .HasColumnName("id_Training")
                    .HasColumnType("int(11)");

                entity.HasOne(d => d.IdProfileNavigation)
                    .WithMany(p => p.Crosstraining)
                    .HasForeignKey(d => d.IdProfile)
                    .HasConstraintName("id_Profile_");

                entity.HasOne(d => d.IdTrainingNavigation)
                    .WithMany(p => p.Crosstraining)
                    .HasForeignKey(d => d.IdTraining)
                    .HasConstraintName("id_Trainings_");
            });

            modelBuilder.Entity<Donor>(entity =>
            {
                entity.ToTable("donor");

                entity.Property(e => e.Id)
                    .HasColumnName("id")
                    .HasColumnType("int(11)");

                entity.Property(e => e.Title)
                    .IsRequired()
                    .HasColumnName("title")
                    .HasColumnType("varchar(255)");
            });

            modelBuilder.Entity<Family>(entity =>
            {
                entity.ToTable("family");

                entity.Property(e => e.Id)
                    .HasColumnName("id")
                    .HasColumnType("int(11)");

                entity.Property(e => e.Title)
                    .IsRequired()
                    .HasColumnName("title")
                    .HasColumnType("varchar(255)");
            });

            modelBuilder.Entity<Gender>(entity =>
            {
                entity.ToTable("gender");

                entity.Property(e => e.Id)
                    .HasColumnName("id")
                    .HasColumnType("int(11)");

                entity.Property(e => e.Title)
                    .IsRequired()
                    .HasColumnName("title")
                    .HasColumnType("varchar(7)");
            });

            modelBuilder.Entity<HeatingType>(entity =>
            {
                entity.ToTable("heating_type");

                entity.Property(e => e.Id)
                    .HasColumnName("id")
                    .HasColumnType("int(11)");

                entity.Property(e => e.Title)
                    .IsRequired()
                    .HasColumnName("title")
                    .HasColumnType("varchar(15)");
            });

            modelBuilder.Entity<Help>(entity =>
            {
                entity.ToTable("help");

                entity.HasIndex(e => e.IdDonor)
                    .HasName("id_donor");

                entity.HasIndex(e => e.IdHelptype)
                    .HasName("id_helptype");

                entity.HasIndex(e => e.IdProfile)
                    .HasName("id_profile");

                entity.HasIndex(e => e.IdProject)
                    .HasName("id_project");

                entity.Property(e => e.Id)
                    .HasColumnName("id")
                    .HasColumnType("int(11)");

                entity.Property(e => e.EndDate)
                    .HasColumnName("end_date")
                    .HasColumnType("date");

                entity.Property(e => e.IdDonor)
                    .HasColumnName("id_donor")
                    .HasColumnType("int(11)")
                    .HasDefaultValueSql("'1'");

                entity.Property(e => e.IdHelptype)
                    .HasColumnName("id_helptype")
                    .HasColumnType("int(11)")
                    .HasDefaultValueSql("'1'");

                entity.Property(e => e.IdProfile)
                    .HasColumnName("id_profile")
                    .HasColumnType("int(11)");

                entity.Property(e => e.IdProject)
                    .HasColumnName("id_project")
                    .HasColumnType("int(11)");

                entity.Property(e => e.StartDate)
                    .HasColumnName("start_date")
                    .HasColumnType("date");

                entity.HasOne(d => d.IdDonorNavigation)
                    .WithMany(p => p.Help)
                    .HasForeignKey(d => d.IdDonor)
                    .HasConstraintName("help_ibfk_1");

                entity.HasOne(d => d.IdHelptypeNavigation)
                    .WithMany(p => p.Help)
                    .HasForeignKey(d => d.IdHelptype)
                    .HasConstraintName("help_ibfk_2");

                entity.HasOne(d => d.IdProfileNavigation)
                    .WithMany(p => p.Help)
                    .HasForeignKey(d => d.IdProfile)
                    .HasConstraintName("help_ibfk_3");

                entity.HasOne(d => d.IdProjectNavigation)
                    .WithMany(p => p.Help)
                    .HasForeignKey(d => d.IdProject)
                    .HasConstraintName("help_ibfk_4");
            });

            modelBuilder.Entity<Helptype>(entity =>
            {
                entity.ToTable("helptype");

                entity.Property(e => e.Id)
                    .HasColumnName("id")
                    .HasColumnType("int(11)");

                entity.Property(e => e.Title)
                    .IsRequired()
                    .HasColumnName("title")
                    .HasColumnType("varchar(255)");
            });

            modelBuilder.Entity<Lead>(entity =>
            {
                entity.ToTable("lead");

                entity.HasIndex(e => e.IdBdistrict)
                    .HasName("id_bdistrict");

                entity.HasIndex(e => e.IdChild)
                    .HasName("id_child");

                entity.HasIndex(e => e.IdFamUnemp)
                    .HasName("id_fam_unemp");

                entity.HasIndex(e => e.IdFamily)
                    .HasName("id_family");

                entity.HasIndex(e => e.IdMigrant)
                    .HasName("id_migrant");

                entity.HasIndex(e => e.IdReason)
                    .HasName("id_reason");

                entity.HasIndex(e => e.IdTypeOfHouse)
                    .HasName("id_type_of_house");

                entity.Property(e => e.Id)
                    .HasColumnName("id")
                    .HasColumnType("int(11)");

                entity.Property(e => e.Adopted)
                    .HasColumnName("adopted")
                    .HasColumnType("tinyint(4)");

                entity.Property(e => e.Categories)
                    .HasColumnName("categories")
                    .HasColumnType("varchar(255)");

                entity.Property(e => e.City)
                    .HasColumnName("city")
                    .HasColumnType("varchar(255)");

                entity.Property(e => e.Datelead)
                    .HasColumnName("datelead")
                    .HasColumnType("datetime");

                entity.Property(e => e.District)
                    .HasColumnName("district")
                    .HasColumnType("varchar(255)");

                entity.Property(e => e.Email)
                    .HasColumnName("email")
                    .HasColumnType("varchar(255)");

                entity.Property(e => e.Fio)
                    .IsRequired()
                    .HasColumnName("fio")
                    .HasColumnType("varchar(255)");

                entity.Property(e => e.FioNeed)
                    .HasColumnName("fio_need")
                    .HasColumnType("varchar(255)");

                entity.Property(e => e.IdBdistrict)
                    .HasColumnName("id_bdistrict")
                    .HasColumnType("int(11)");

                entity.Property(e => e.IdChild)
                    .HasColumnName("id_child")
                    .HasColumnType("int(11)");

                entity.Property(e => e.IdFamUnemp)
                    .HasColumnName("id_fam_unemp")
                    .HasColumnType("int(11)");

                entity.Property(e => e.IdFamily)
                    .HasColumnName("id_family")
                    .HasColumnType("int(11)");

                entity.Property(e => e.IdMigrant)
                    .HasColumnName("id_migrant")
                    .HasColumnType("int(11)");

                entity.Property(e => e.IdReason)
                    .HasColumnName("id_reason")
                    .HasColumnType("int(11)");

                entity.Property(e => e.IdTypeOfHouse)
                    .HasColumnName("id_type_of_house")
                    .HasColumnType("int(11)");

                entity.Property(e => e.Income)
                    .HasColumnName("income")
                    .HasColumnType("tinyint(4)");

                entity.Property(e => e.Need)
                    .HasColumnName("need")
                    .HasColumnType("varchar(255)");

                entity.Property(e => e.Phone)
                    .IsRequired()
                    .HasColumnName("phone")
                    .HasColumnType("varchar(255)");

                entity.Property(e => e.Subcontact)
                    .HasColumnName("subcontact")
                    .HasColumnType("varchar(255)");

                entity.Property(e => e.Volunteer)
                    .HasColumnName("volunteer")
                    .HasColumnType("tinyint(4)");

                entity.HasOne(d => d.IdBdistrictNavigation)
                    .WithMany(p => p.Lead)
                    .HasForeignKey(d => d.IdBdistrict)
                    .OnDelete(DeleteBehavior.SetNull)
                    .HasConstraintName("lead_ibfk_1");

                entity.HasOne(d => d.IdChildNavigation)
                    .WithMany(p => p.Lead)
                    .HasForeignKey(d => d.IdChild)
                    .OnDelete(DeleteBehavior.SetNull)
                    .HasConstraintName("lead_ibfk_2");

                entity.HasOne(d => d.IdFamUnempNavigation)
                    .WithMany(p => p.Lead)
                    .HasForeignKey(d => d.IdFamUnemp)
                    .OnDelete(DeleteBehavior.SetNull)
                    .HasConstraintName("lead_ibfk_4");

                entity.HasOne(d => d.IdFamilyNavigation)
                    .WithMany(p => p.Lead)
                    .HasForeignKey(d => d.IdFamily)
                    .OnDelete(DeleteBehavior.SetNull)
                    .HasConstraintName("lead_ibfk_3");

                entity.HasOne(d => d.IdMigrantNavigation)
                    .WithMany(p => p.Lead)
                    .HasForeignKey(d => d.IdMigrant)
                    .OnDelete(DeleteBehavior.SetNull)
                    .HasConstraintName("lead_ibfk_5");

                entity.HasOne(d => d.IdReasonNavigation)
                    .WithMany(p => p.Lead)
                    .HasForeignKey(d => d.IdReason)
                    .OnDelete(DeleteBehavior.SetNull)
                    .HasConstraintName("lead_ibfk_6");

                entity.HasOne(d => d.IdTypeOfHouseNavigation)
                    .WithMany(p => p.Lead)
                    .HasForeignKey(d => d.IdTypeOfHouse)
                    .OnDelete(DeleteBehavior.SetNull)
                    .HasConstraintName("lead_ibfk_7");
            });

            modelBuilder.Entity<LeadBdisctrict>(entity =>
            {
                entity.ToTable("lead_bdisctrict");

                entity.Property(e => e.Id)
                    .HasColumnName("id")
                    .HasColumnType("int(11)");

                entity.Property(e => e.Title)
                    .IsRequired()
                    .HasColumnName("title")
                    .HasColumnType("varchar(255)");
            });

            modelBuilder.Entity<LeadChildrens>(entity =>
            {
                entity.ToTable("lead_childrens");

                entity.Property(e => e.Id)
                    .HasColumnName("id")
                    .HasColumnType("int(11)");

                entity.Property(e => e.Title)
                    .IsRequired()
                    .HasColumnName("title")
                    .HasColumnType("varchar(255)");
            });

            modelBuilder.Entity<LeadFamily>(entity =>
            {
                entity.ToTable("lead_family");

                entity.Property(e => e.Id)
                    .HasColumnName("id")
                    .HasColumnType("int(11)");

                entity.Property(e => e.Title)
                    .IsRequired()
                    .HasColumnName("title")
                    .HasColumnType("varchar(255)");
            });

            modelBuilder.Entity<LeadFamUnemp>(entity =>
            {
                entity.ToTable("lead_fam_unemp");

                entity.Property(e => e.Id)
                    .HasColumnName("id")
                    .HasColumnType("int(11)");

                entity.Property(e => e.Title)
                    .IsRequired()
                    .HasColumnName("title")
                    .HasColumnType("varchar(255)");
            });

            modelBuilder.Entity<LeadMigrant>(entity =>
            {
                entity.ToTable("lead_migrant");

                entity.Property(e => e.Id)
                    .HasColumnName("id")
                    .HasColumnType("int(11)");

                entity.Property(e => e.Title)
                    .IsRequired()
                    .HasColumnName("title")
                    .HasColumnType("varchar(255)");
            });

            modelBuilder.Entity<LeadReason>(entity =>
            {
                entity.ToTable("lead_reason");

                entity.Property(e => e.Id)
                    .HasColumnName("id")
                    .HasColumnType("int(11)");

                entity.Property(e => e.Title)
                    .IsRequired()
                    .HasColumnName("title")
                    .HasColumnType("varchar(255)");
            });

            modelBuilder.Entity<Need>(entity =>
            {
                entity.ToTable("need");

                entity.Property(e => e.Id)
                    .HasColumnName("id")
                    .HasColumnType("int(11)");

                entity.Property(e => e.Title)
                    .IsRequired()
                    .HasColumnName("title")
                    .HasColumnType("varchar(255)");
            });

            modelBuilder.Entity<People>(entity =>
            {
                entity.ToTable("people");

                entity.HasIndex(e => e.IdCity)
                    .HasName("id_idx");

                entity.HasIndex(e => e.IdGender)
                    .HasName("id_gender_idx");

                entity.Property(e => e.Id)
                    .HasColumnName("id")
                    .HasColumnType("int(11)");

                entity.Property(e => e.Email)
                    .HasColumnName("email")
                    .HasColumnType("varchar(255)");

                entity.Property(e => e.IdCity)
                    .HasColumnName("id_City")
                    .HasColumnType("int(11)");

                entity.Property(e => e.IdGender)
                    .HasColumnName("id_Gender")
                    .HasColumnType("int(11)");

                entity.Property(e => e.Inn)
                    .HasColumnName("INN")
                    .HasColumnType("varchar(255)");

                entity.Property(e => e.Name).HasColumnType("varchar(225)");

                entity.Property(e => e.Passport).HasColumnType("varchar(225)");

                entity.Property(e => e.Patr).HasColumnType("varchar(255)");

                entity.Property(e => e.Phone).HasColumnType("varchar(255)");

                entity.Property(e => e.SName)
                    .HasColumnName("sName")
                    .HasColumnType("varchar(225)");

                entity.Property(e => e.Year).HasColumnType("int(11)");

                entity.HasOne(d => d.IdCityNavigation)
                    .WithMany(p => p.People)
                    .HasForeignKey(d => d.IdCity)
                    .OnDelete(DeleteBehavior.SetNull)
                    .HasConstraintName("id_city");

                entity.HasOne(d => d.IdGenderNavigation)
                    .WithMany(p => p.People)
                    .HasForeignKey(d => d.IdGender)
                    .OnDelete(DeleteBehavior.SetNull)
                    .HasConstraintName("id_gender");
            });

            modelBuilder.Entity<Profile>(entity =>
            {
                entity.ToTable("profile");

                entity.HasIndex(e => e.IdFamiliy)
                    .HasName("id_families_idx");

                entity.HasIndex(e => e.IdPeople)
                    .HasName("id_people_idx");

                entity.HasIndex(e => e.IdTypeHeating)
                    .HasName("id_type_heating_idx");

                entity.HasIndex(e => e.IdTypeOfHouse)
                    .HasName("id_type_of_house_idx");

                entity.Property(e => e.Id)
                    .HasColumnName("id")
                    .HasColumnType("int(11)");

                entity.Property(e => e.DestroyedHouse)
                    .HasColumnName("Destroyed_house")
                    .HasColumnType("tinyint(4)");

                entity.Property(e => e.ForcedMigrant)
                    .HasColumnName("Forced_migrant")
                    .HasColumnType("tinyint(4)");

                entity.Property(e => e.IdFamiliy)
                    .HasColumnName("id_Familiy")
                    .HasColumnType("int(11)");

                entity.Property(e => e.IdPeople)
                    .HasColumnName("id_people")
                    .HasColumnType("int(11)");

                entity.Property(e => e.IdTypeHeating)
                    .HasColumnName("id_type_heating")
                    .HasColumnType("int(11)");

                entity.Property(e => e.IdTypeOfHouse)
                    .HasColumnName("id_type_of_house")
                    .HasColumnType("int(11)");

                entity.Property(e => e.Note).HasColumnType("varchar(255)");

                entity.Property(e => e.NumbOfChild)
                    .HasColumnName("Numb_of_Child")
                    .HasColumnType("int(11)");

                entity.Property(e => e.RegDate)
                    .HasColumnType("datetime")
                    .HasDefaultValueSql("'CURRENT_TIMESTAMP'");

                entity.HasOne(d => d.IdFamiliyNavigation)
                    .WithMany(p => p.Profile)
                    .HasForeignKey(d => d.IdFamiliy)
                    .OnDelete(DeleteBehavior.SetNull)
                    .HasConstraintName("profile_ibfk_1");

                entity.HasOne(d => d.IdPeopleNavigation)
                    .WithMany(p => p.Profile)
                    .HasForeignKey(d => d.IdPeople)
                    .HasConstraintName("profile_ibfk_2");

                entity.HasOne(d => d.IdTypeHeatingNavigation)
                    .WithMany(p => p.Profile)
                    .HasForeignKey(d => d.IdTypeHeating)
                    .OnDelete(DeleteBehavior.SetNull)
                    .HasConstraintName("profile_ibfk_3");

                entity.HasOne(d => d.IdTypeOfHouseNavigation)
                    .WithMany(p => p.Profile)
                    .HasForeignKey(d => d.IdTypeOfHouse)
                    .OnDelete(DeleteBehavior.SetNull)
                    .HasConstraintName("profile_ibfk_4");
            });

            modelBuilder.Entity<Project>(entity =>
            {
                entity.ToTable("project");

                entity.Property(e => e.Id)
                    .HasColumnName("id")
                    .HasColumnType("int(11)");

                entity.Property(e => e.Title)
                    .IsRequired()
                    .HasColumnName("title")
                    .HasColumnType("varchar(255)");
            });

            modelBuilder.Entity<Training>(entity =>
            {
                entity.ToTable("training");

                entity.Property(e => e.Id)
                    .HasColumnName("id")
                    .HasColumnType("int(11)");

                entity.Property(e => e.Title)
                    .IsRequired()
                    .HasColumnName("title")
                    .HasColumnType("varchar(255)");
            });

            modelBuilder.Entity<TypeOfHouse>(entity =>
            {
                entity.ToTable("type_of_house");

                entity.Property(e => e.Id)
                    .HasColumnName("id")
                    .HasColumnType("int(11)");

                entity.Property(e => e.Title)
                    .IsRequired()
                    .HasColumnName("title")
                    .HasColumnType("varchar(15)");
            });

            modelBuilder.Entity<User>(entity =>
            {
                entity.ToTable("user");

                entity.HasIndex(e => e.RoleId)
                    .HasName("role_id");

                entity.Property(e => e.Id)
                    .HasColumnName("id")
                    .HasColumnType("int(11)");

                entity.Property(e => e.FName)
                    .HasColumnName("fName")
                    .HasColumnType("varchar(30)");

                entity.Property(e => e.Login)
                    .IsRequired()
                    .HasColumnName("login")
                    .HasColumnType("varchar(30)");

                entity.Property(e => e.Pass)
                    .IsRequired()
                    .HasColumnName("pass")
                    .HasColumnType("varchar(255)");

                entity.Property(e => e.Patr)
                    .HasColumnName("patr")
                    .HasColumnType("varchar(30)");

                entity.Property(e => e.RoleId)
                    .HasColumnName("role_id")
                    .HasColumnType("int(11)");

                entity.Property(e => e.SName)
                    .HasColumnName("sName")
                    .HasColumnType("varchar(30)");

                entity.Property(e => e.Salt)
                    .HasColumnName("salt")
                    .HasColumnType("varchar(255)");

                entity.Property(e => e.Token)
                    .HasColumnName("token")
                    .HasColumnType("varchar(255)");

                entity.HasOne(d => d.Role)
                    .WithMany(p => p.User)
                    .HasForeignKey(d => d.RoleId)
                    .OnDelete(DeleteBehavior.SetNull)
                    .HasConstraintName("User_ibfk_1");
            });

            modelBuilder.Entity<UserRole>(entity =>
            {
                entity.ToTable("user_role");

                entity.Property(e => e.Id)
                    .HasColumnName("id")
                    .HasColumnType("int(11)");

                entity.Property(e => e.Title)
                    .IsRequired()
                    .HasColumnName("title")
                    .HasColumnType("varchar(20)");
            });
        }
    }
}
